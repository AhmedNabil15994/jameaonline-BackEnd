<?php

namespace Modules\Order\Http\Controllers\WebService;

use Exception;
use Modules\Cart\Traits\CartTrait;
use Modules\Catalog\Repositories\WebService\CatalogRepository as Catalog;
use Modules\Vendor\Repositories\WebService\VendorRepository as Vendor;
use Illuminate\Http\Request;
use Modules\Order\Repositories\WebService\OrderRepository as Order;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Cart\Transformers\WebService\CartResource;
use Modules\Cart\Transformers\WebService\CartVendorResource;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\ProductAddon;
use stdClass;

class ReOrderController extends WebServiceController
{
    use CartTrait;

    protected $order;
    protected $catalog;
    protected $vendor;

    function __construct(
        Order $order,
        Catalog $catalog,
        Vendor $vendor
    ) {
        $this->order = $order;
        $this->catalog = $catalog;
        $this->vendor = $vendor;
    }

    public function reOrder(Request $request, $id)
    {
        $order = $this->order->findByIdWithRelations($id, [
            'orderProducts.product',
            'orderProducts.orderVariant',
            'orderVariations.variant.product',
            'orderVariations.orderVariantValues.productVariantValue',
        ]);
        if (!$order)
            return $this->error(__('order::api.orders.validations.order_not_found'), [], 422);

        $userToken = auth('api')->check() ? auth('api')->id() : $request->user_token;
        $customRequest = [];
        $customRequest['user_token'] = $userToken;
        $allOrderProducts = $order->orderProducts->mergeRecursive($order->orderVariations);

        if ($allOrderProducts->count() > 0) {
            $customProducts = [];
            foreach ($allOrderProducts as $key => $orderDetails) {
                if (isset($orderDetails->product)) { // main product
                    $customProducts[$key]['product_type'] = 'product';
                    $customProducts[$key]['product_id'] = $orderDetails->product->id;
                    $productAddons = json_decode($orderDetails->add_ons_option_ids, true);
                    if (!empty($productAddons)) {
                        foreach ($productAddons['data'] as $i => $value) {
                            $customProducts[$key]['addonsOptions'][$i]['id'] = $value['id'];
                            $customProducts[$key]['addonsOptions'][$i]['options'] = $value['options'];
                        }
                    }
                } else { // variant product
                    $vendorId = $orderDetails->variant->product->vendor_id ?? null;
                    $productModel = $orderDetails->variant;
                    $productModel->vendor_id = $vendorId;
                    $customProducts[$key]['product_type'] = 'variation';
                    $customProducts[$key]['product_id'] = $orderDetails->variant->id;
                }
                $customProducts[$key]['qty'] = $orderDetails->qty;
                $customProducts[$key]['notes'] = $orderDetails->notes;
            }
            $customRequest['products'] = $customProducts;
        }

        $cartResponse = $this->createOrUpdate($customRequest);
        if (gettype($cartResponse) == 'string')
            return $this->error($cartResponse, [], 422);

        return $this->response($this->responseData($cartResponse));
    }

    public function createOrUpdate($request)
    {
        $userToken = $request['user_token'] ?? null;

        foreach ($request['products'] as $index => $customProduct) {
            if ($customProduct['product_type'] == 'product') {
                // execute product addons validation
                $errors = $this->validateProductAddons($customProduct);
                if (gettype($errors) == 'string')
                    return $errors;

                $product = $this->catalog->findOneProduct($customProduct['product_id']);
                if (!$product)
                    return __('cart::api.cart.product.not_found') . $customProduct['product_id'];

                $product->product_type = 'product';
                $vendorId = $product->vendor_id ?? null;
            } else {
                // $request->product_id = $this->getVariationId($request->product_id);
                $product = $this->catalog->findOneProductVariant($customProduct['product_id']);
                if (!$product)
                    return __('cart::api.cart.product.not_found') . $customProduct['product_id'];

                $product->product_type = 'variation';
                $vendorId = $product->product->vendor_id ?? null;
                $product->vendor_id = $vendorId;

                // Get variant product options and values
                $options = [];
                foreach ($product->productValues as $k => $value) {
                    $options[] = $value->productOption->option->id;
                }
                $selectedOptionsValue = $product->productValues->pluck('option_value_id')->toArray();
                // Append options and options values to current request
                $customProduct['selectedOptions'] = json_encode($options);
                $customProduct['selectedOptionsValue'] = json_encode($selectedOptionsValue);
            }

            if (getCartContent($userToken)->count() > 0 && !is_null($vendorId) && $vendorId != (getCartContent($userToken)->first()->attributes['vendor_id'] ?? ''))
                return __('catalog::frontend.products.alerts.empty_cart_firstly');

            $customProduct['user_token'] = $userToken;
            $httpRequest = new Request($customProduct);
            $res = $this->addOrUpdateCart($product, $httpRequest);
            if (gettype($res) == 'string')
                return $res;
        }

        return new Request($customProduct);
    }

    ############# Start: Cart Custom Validation ############
    public function validateProductAddons($customProduct)
    {
        $cartProduct = Product::with('addOns')->find($customProduct['product_id']);
        $productAddonCategoriesError = $this->printProductAddonCatValidation($cartProduct, $customProduct);
        if ($customProduct['product_type'] == 'product') {
            if (isset($customProduct['addonsOptions']) && !empty($customProduct['addonsOptions'])) {
                foreach ($customProduct['addonsOptions'] as $k => $value) {

                    $addOns = ProductAddon::where('product_id', $customProduct['product_id'])->where('addon_category_id', $value['id'])->first();
                    if (!$addOns) {
                        return __('cart::api.validations.addons.addons_not_found') . ' - ' . __('cart::api.validations.addons.addons_number') . ': ' . $value['id'];
                    }

                    $optionsIds = $addOns->addonOptions ? $addOns->addonOptions->pluck('addon_option_id')->toArray() : [];
                    if ($addOns->type == 'single' && isset($value['options']) && !in_array($value['options'][0], $optionsIds)) {
                        return __('cart::api.validations.addons.option_not_found') . ' - ' . __('cart::api.validations.addons.addons_number') . ': ' . $value['options'][0];
                    }

                    if ($addOns->type == 'multi') {
                        if ($addOns->max_options_count != null && isset($value['options']) && count($value['options']) > intval($addOns->max_options_count)) {
                            return __('cart::api.validations.addons.selected_options_greater_than_options_count') . ': ' . $addOns->addonCategory->getTranslation('title', locale());
                        }

                        if ($addOns->min_options_count != null && isset($value['options']) && count($value['options']) < intval($addOns->min_options_count)) {
                            return __('cart::api.validations.addons.selected_options_less_than_options_count') . ': ' . $addOns->addonCategory->getTranslation('title', locale());
                        }

                        if (isset($value['options']) && count($value['options']) > 0) {
                            foreach ($value['options'] as $i => $item) {
                                if (!in_array($item, $optionsIds)) {
                                    return __('cart::api.validations.addons.option_not_found') . ' - ' . __('cart::api.validations.addons.addons_number') . ': ' . $item;
                                }
                            }
                        }
                    }
                }
            }

            if (!empty($productAddonCategoriesError)) {
                $msg = implode(', ', $productAddonCategoriesError);
                return __('cart::api.validations.addons.select_required_product_addon_category') . ': ' . $msg;
            }
        }
        return true;
    }

    private function printProductAddonCatValidation($cartProduct, $customProduct)
    {
        $msg = [];
        if (!empty($cartProduct->addOns) && empty($customProduct['addonsOptions'])) {
            foreach ($cartProduct->addOns as $k => $addon) {
                if ($addon && $addon->is_required == 1) {
                    $msg[] = $addon->addonCategory->title;
                }
            }
        } elseif (!empty($customProduct['addonsOptions'])) {
            $productAddonCategories = array_column($cartProduct->addOns->toArray() ?? [], 'addon_category_id');
            $diffAddonCats = array_values(array_diff($productAddonCategories, array_map('intval', array_column($customProduct['addonsOptions'] ?? [], 'id') ?? [])));
            if (!empty($diffAddonCats)) {
                foreach ($diffAddonCats as $k => $id) {
                    $addOns = ProductAddon::where('product_id', $customProduct['product_id'])->where('addon_category_id', $id)->first();
                    if ($addOns && $addOns->is_required == 1) {
                        $msg[] = $addOns->addonCategory->title;
                    }
                }
            }
        }
        return $msg;
    }
    ############# End: Cart Custom Validation ############

    ############# Start: Cart Response ############
    public function responseData($request)
    {
        $collections = collect($this->cartDetails($request));
        $data = $this->returnCustomResponse($request);
        $data['items'] = CartResource::collection($collections);

        $vendorId = getCartContent($request['user_token'])->first()->attributes['vendor_id'] ?? null;
        $vendorObject = $this->vendor->findById($vendorId);
        $data['vendor'] = $vendorObject ? new CartVendorResource($vendorObject) : null;

        if (!is_null(getCartItemsCouponValue()) && getCartItemsCouponValue() > 0) {
            $data['coupon_value'] = number_format(getCartItemsCouponValue(), 2);
        } else {
            $couponDiscount = $this->getCondition($request, 'coupon_discount');
            $data['coupon_value'] = !is_null($couponDiscount) ? $couponDiscount->getValue() : null;
        }

        return $data;
    }

    protected function returnCustomResponse($request)
    {
        return [
            'conditions' => $this->getCartConditions($request),
            'subTotal' => number_format($this->cartSubTotal($request), 2),
            'total' => number_format($this->cartTotal($request), 2),
            'count' => $this->cartCount($request),
        ];
    }
    ############# End: Cart Response ############

}
