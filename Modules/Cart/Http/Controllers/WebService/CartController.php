<?php

namespace Modules\Cart\Http\Controllers\WebService;

use Cart;
use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Cart\Http\Requests\Api\CompanyDeliveryFeesConditionRequest;
use Modules\Cart\Http\Requests\Api\CreateOrUpdateCartRequest;
use Modules\Cart\Traits\CartTrait;
use Modules\Cart\Transformers\WebService\CartResource;
use Modules\Cart\Transformers\WebService\CartVendorResource;
use Modules\Catalog\Repositories\WebService\CatalogRepository as Product;
use Modules\Company\Repositories\WebService\CompanyRepository as CompanyRepo;
use Modules\Coupon\Http\Controllers\WebService\CouponController;
use Modules\User\Repositories\WebService\AddressRepository as AddressRepo;
use Modules\Vendor\Repositories\WebService\VendorRepository as Vendor;

class CartController extends WebServiceController
{
    use CartTrait;

    protected $product;
    protected $company;
    protected $userAddress;
    protected $vendor;

    public function __construct(Product $product, CompanyRepo $company, AddressRepo $userAddress, Vendor $vendor)
    {
        $this->product = $product;
        $this->company = $company;
        $this->userAddress = $userAddress;
        $this->vendor = $vendor;
    }

    public function index(Request $request)
    {
        if (is_null($request->user_token)) {
            return $this->error(__('apps::frontend.general.user_token_not_found'), [], 422);
        }
        return $this->response($this->responseData($request));
    }

    public function createOrUpdate(CreateOrUpdateCartRequest $request)
    {
        /* if (is_null($request->user_token)) {
        return $this->error(__('apps::frontend.general.user_token_not_found'), [], 422);
        } */

        $userToken = $request->user_token ?? null;
        // check if product single OR variable (variant)
        if ($request->product_type == 'product') {
            $product = $this->product->findOneProduct($request->product_id);
            if (!$product) {
                return $this->error(__('cart::api.cart.product.not_found') . $request->product_id, [], 422);
            }

            $product->product_type = 'product';
            $vendorId = $product->vendor_id ?? null;
        } else {
            // $request->product_id = $this->getVariationId($request->product_id);
            $product = $this->product->findOneProductVariant($request->product_id);
            if (!$product) {
                return $this->error(__('cart::api.cart.product.not_found') . $request->product_id, [], 422);
            }

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
            // - encode data to match frontend scenario
            $request->request->add([
                'selectedOptions' => json_encode($options),
                'selectedOptionsValue' => json_encode($selectedOptionsValue),
            ]);

            /*if (!isset($request->selectedOptions) || empty($request->selectedOptions)) {
        $error = 'Please, Enter Selected Options';
        return $this->error($error, [], 422);
        }

        if (!isset($request->selectedOptionsValue) || empty($request->selectedOptionsValue)) {
        $error = 'Please, Enter Selected Options Values';
        return $this->error($error, [], 422);
        }*/
        }

        // if (config('setting.other.select_shipping_provider') == 'vendor_delivery') {
        if (getCartContent($userToken)->count() > 0 && !is_null($vendorId) && $vendorId != (getCartContent($userToken)->first()->attributes['vendor_id'] ?? '')) {
            return $this->error(__('catalog::frontend.products.alerts.empty_cart_firstly'), [], 422);
        }

        // }

        $res = $this->addOrUpdateCart($product, $request);
        if (gettype($res) == 'string') {
            return $this->error($res, [], 422);
        }

        $couponDiscount = $this->getCondition($request, 'coupon_discount');
        if (!is_null($couponDiscount)) {
            $couponCode = $couponDiscount->getAttributes()['coupon']->code ?? null;
            $this->applyCouponOnCart($request->user_token, $couponCode);
        }

        return $this->response($this->responseData($request));
    }

    public function remove(Request $request, $id)
    {
        $this->removeItem($request, $id);
        $couponDiscount = $this->getCondition($request, 'coupon_discount');
        if (!is_null($couponDiscount)) {
            $couponCode = $couponDiscount->getAttributes()['coupon']->code ?? null;
            $this->applyCouponOnCart($request->user_token, $couponCode);
        }
        return $this->response($this->responseData($request));
    }

    public function addCompanyDeliveryFeesCondition(CompanyDeliveryFeesConditionRequest $request)
    {
        /*if (getCartSubTotal($request->user_token) <= 0)
        return $this->error(__('coupon::api.coupons.validation.cart_is_empty'), [], 422);*/

        $userToken = $request->user_token;

        if (auth('api')->check()) {
            // Get user address and state by address_id
            $address = $this->userAddress->findById($request->address_id);
            if (!$address) {
                return $this->error(__('user::webservice.address.errors.address_not_found'));
            }

            $request->request->add(['state_id' => $address->state_id]);
        }

        $vendorId = getCartContent($userToken)->first()->attributes['vendor_id'] ?? null;
        if (config('setting.other.select_shipping_provider') == 'shipping_company') {
            $companyId = config('setting.other.shipping_company') ?? 0;
            $price = $this->company->getDeliveryPrice($request->state_id, $companyId);
        } elseif (config('setting.other.select_shipping_provider') == 'vendor_delivery') {
            // $vendorId = getCartContent($userToken)->first()->attributes['vendor_id'] ?? null;
            $price = $this->vendor->getDeliveryPrice($request->state_id ?? null, $vendorId);
        } else {
            $price = null;
        }

        $request->request->add(['vendor_id' => $vendorId]);

        if ($price) {
            $this->removeConditionByName($request, 'company_delivery_fees');
            $this->companyDeliveryChargeCondition($request, floatval($price));
        } else {
            $this->removeConditionByName($request, 'company_delivery_fees');
            return $this->error(__('catalog::frontend.checkout.validation.state_not_supported_by_company'), [], 422);
        }

        $result = $this->returnCustomResponse($request);
        return $this->response($result);
    }

    public function removeCondition(Request $request, $name)
    {
        $this->removeConditionByName($request, $name);
        return $this->response($this->responseData($request));
    }

    public function clear(Request $request)
    {
        $this->clearCart($request->user_token);
        return $this->response($this->responseData($request));
    }

    public function responseData($request)
    {
        $collections = collect($this->cartDetails($request));
        $data = $this->returnCustomResponse($request);
        $data['items'] = CartResource::collection($collections);

        /*if (config('setting.other.select_shipping_provider') == 'vendor_delivery') {
        $vendorId = getCartContent($request['user_token'])->first()->attributes['vendor_id'] ?? null;
        $vendorObject = $this->vendor->findById($vendorId);
        $data['vendor'] = $vendorObject ? new CartVendorResource($vendorObject) : null;
        } else {
        $data['vendor'] = null;
        }*/

        $vendorId = getCartContent($request['user_token'])->first()->attributes['vendor_id'] ?? null;
        $vendorObject = $this->vendor->findById($vendorId);
        $data['vendor'] = $vendorObject ? new CartVendorResource($vendorObject) : null;

        $couponDiscount = $this->getCondition($request, 'coupon_discount');
        if (!is_null($couponDiscount)) {
            if (!is_null(getCartItemsCouponValue()) && getCartItemsCouponValue() > 0) {
                $data['coupon_value'] = number_format(getCartItemsCouponValue(), 3);
            } else {
                $data['coupon_value'] = number_format($couponDiscount->getValue(), 3);
            }
        } else {
            $data['coupon_value'] = null;
        }

        return $data;
    }

    protected function getVariationId($varId)
    {
        return substr($varId, strpos($varId, "-") + 1);
    }

    protected function returnCustomResponse($request)
    {
        return [
            'conditions' => $this->getCartConditions($request),
            'subTotal' => number_format($this->cartSubTotal($request), 3),
            'total' => number_format($this->cartTotal($request), 3),
            'count' => $this->cartCount($request),
        ];
    }

    public function applyCouponOnCart($user_token, $couponCode)
    {
        $request = new \Illuminate\Http\Request();
        $customRequest = $request->replace(['user_token' => $user_token, 'code' => $couponCode]);
        $result = (new CouponController)->checkCoupon($customRequest);
        return true;
    }
}
