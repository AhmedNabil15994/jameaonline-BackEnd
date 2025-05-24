<?php

namespace Modules\Order\Http\Controllers\WebService;

use Modules\Cart\Traits\CartTrait;
use Modules\Catalog\Repositories\WebService\CatalogRepository as Catalog;
use Modules\Order\Http\Requests\WebService\CreateOrderRequest;
use Modules\Order\Transformers\WebService\OrderProductResource;
use Modules\User\Repositories\WebService\AddressRepository;
use Modules\Vendor\Repositories\WebService\VendorRepository as Vendor;
use Notification;
use Illuminate\Http\Request;
use Modules\Order\Events\ActivityLog;
use Modules\Order\Events\VendorOrder;
use Modules\Transaction\Services\UPaymentService;
use Modules\Order\Transformers\WebService\OrderResource;
use Modules\Order\Repositories\WebService\OrderRepository as Order;
use Modules\Company\Repositories\WebService\CompanyRepository as Company;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Order\Http\Requests\WebService\RateOrderRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Order\Transformers\WebService\OrderHistoryResource;
use Modules\Order\Transformers\WebService\OrderHistoryStatusResource;

class OrderController extends WebServiceController
{
    use CartTrait;

    protected $payment;
    protected $order;
    protected $company;
    protected $catalog;
    protected $address;
    protected $vendor;

    function __construct(
        Order $order,
        UPaymentService $payment,
        Company $company,
        Catalog $catalog,
        AddressRepository $address,
        Vendor $vendor
    ) {
        $this->payment = $payment;
        $this->order = $order;
        $this->company = $company;
        $this->catalog = $catalog;
        $this->address = $address;
        $this->vendor = $vendor;
    }

    public function createOrder(CreateOrderRequest $request)
    {
        if (auth('api')->check())
            $userToken = auth('api')->user()->id;
        else
            $userToken = $request->user_id;

        // Check if address is not found
        if ($request->address_type == 'selected_address') {
            // get address by id
            $companyDeliveryFees = getCartConditionByName($userToken, 'company_delivery_fees');
            $addressId = isset($companyDeliveryFees->getAttributes()['address_id'])
                ? $companyDeliveryFees->getAttributes()['address_id']
                : null;
            $address = $this->address->findByIdWithoutAuth($addressId);
            if (!$address)
                return $this->error(__('user::webservice.address.errors.address_not_found'), [], 422);
        }

        foreach (getCartContent($userToken) as $key => $item) {

            if ($item->attributes->product->product_type == 'product') {
                $cartProduct = $item->attributes->product;
                $product = $this->catalog->findOneProduct($cartProduct->id);
                if (!$product)
                    return $this->error(__('cart::api.cart.product.not_found') . $cartProduct->id, [], 422);

                ### Start - Check Single Addons Selections - Validation ###
                $selectedAddons = $item->attributes->has('addonsOptions') ? $item->attributes['addonsOptions']['data'] : [];
                $addOnsCheck = $this->checkProductAddonsValidation($selectedAddons, $product);
                if (gettype($addOnsCheck) == 'string')
                    return $this->error($addOnsCheck . ' : ' . $cartProduct->translate(locale())->title, [], 422);
                ### End - Check Single Addons Selections - Validation ###

                $product->product_type = 'product';
            } else {
                $cartProduct = $item->attributes->product;
                $product = $this->catalog->findOneProductVariant($cartProduct->id);
                if (!$product)
                    return $this->error(__('cart::api.cart.product.not_found') . $cartProduct->id, [], 422);

                $product->product_type = 'variation';
            }

            $checkPrdFound = $this->productFound($product, $item);
            if ($checkPrdFound)
                return $this->error($checkPrdFound, [], 422);

            $checkPrdStatus = $this->checkProductActiveStatus($product, $request);
            if ($checkPrdStatus)
                return $this->error($checkPrdStatus, [], 422);

            if (!is_null($product->qty)) {
                $checkPrdMaxQty = $this->checkMaxQty($product, $item->quantity);
                if ($checkPrdMaxQty)
                    return $this->error($checkPrdMaxQty, [], 422);
            }

            $checkVendorStatus = $this->vendorStatus($product);
            if ($checkVendorStatus)
                return $this->error($checkVendorStatus, [], 422);
        }

        $order = $this->order->create($request, $userToken);
        if (!$order)
            return $this->error('error', [], 422);

        if ($request['payment'] != 'cash' && getCartTotal() > 0) {
            $vendorId = getCartContent($userToken)->first()->attributes['vendor_id'] ?? null;
            $vendorModel = $this->vendor->findById($vendorId);
            if (!$vendorModel)
                return $this->error('order::frontend.orders.index.alerts.order_vendor_not_available', [], 422);

            $vendorPaymentData = [
                'charges' => $vendorModel->payment_data['charges'] ?? 0.350,
                'cc_charges' => $vendorModel->payment_data['cc_charges'] ?? 2.7,
                'ibans' => $vendorModel->payment_data['ibans'] ?? '',
            ];
            $payment = $this->payment->send($order, $request['payment'], 'api-order', $vendorPaymentData);
            if (is_null($payment))
                return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
            else
                return $this->response(['paymentUrl' => $payment]);
        }

        $this->fireLog($order);
        $this->clearCart($userToken);

        return $this->response(new OrderResource($order));
    }

    public function webhooks(Request $request)
    {
        $this->order->updateOrder($request);
    }

    public function success(Request $request)
    {
        $order = $this->order->updateOrder($request);
        if ($order) {
            $orderDetails = $this->order->findById($request['OrderID']);
            $userToken = $orderDetails->user_id ?? $orderDetails->user_token;
            if ($orderDetails) {
                $this->fireLog($orderDetails);
                $this->clearCart($userToken);
                return $this->response(new OrderResource($orderDetails));
            } else
                return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
        }
    }

    public function failed(Request $request)
    {
        $this->order->updateOrder($request);
        return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
    }

    public function userOrdersList(Request $request)
    {
        if (auth('api')->check()) {
            $userId = auth('api')->id();
            $userColumn = 'user_id';
        } else {
            $userId = $request->user_token ?? 'not_found';
            $userColumn = 'user_token';
        }
        $orders = $this->order->getAllByUser($userId, $userColumn);
        return $this->response(OrderResource::collection($orders));
    }

    public function getOrderDetails(Request $request, $id)
    {
        $order = $this->order->findById($id);
        if (!$order)
            return $this->error(__('order::api.orders.validations.order_not_found'), [], 422);

        $allOrderProducts = $order->orderProducts->mergeRecursive($order->orderVariations);
        return $this->response(OrderProductResource::collection($allOrderProducts));
    }

    public function getOrderStatuses(Request $request, $id)
    {
        $order = $this->order->findById($id);
        if (!$order)
            return $this->error(__('order::api.orders.validations.order_not_found'), [], 422);

        $orderHistories = $this->order->getOrderHistories($id);
        return $this->response(OrderHistoryResource::collection($orderHistories));
    }

    public function fireLog($order)
    {
        $dashboardUrl = LaravelLocalization::localizeUrl(url(route('dashboard.orders.show', [$order->id, 'current_orders'])));
        $data = [
            'id' => $order->id,
            'type' => 'orders',
            'url' => $dashboardUrl,
            'description_en' => 'New Order',
            'description_ar' => 'طلب جديد ',
        ];
        $data2 = [];

        if ($order->vendors) {
            foreach ($order->vendors as $k => $value) {
                $vendor = $this->vendor->findById($value->id);
                if ($vendor) {
                    $vendorUrl = LaravelLocalization::localizeUrl(url(route('vendor.orders.show', $order->id)));
                    $data2 = [
                        'ids' => $vendor->sellers->pluck('id'),
                        'type' => 'vendor',
                        'url' => $vendorUrl,
                        'description_en' => 'New Order',
                        'description_ar' => 'طلب جديد',
                    ];
                }
            }
        }

        event(new ActivityLog($data));
        if (count($data2) > 0) {
            event(new VendorOrder($data2));
        }
    }

    public function rateOrder(RateOrderRequest $request, $id)
    {
        $order = $this->order->findByIdWithUserId($id);
        if (!$order)
            return $this->error(__('order::api.orders.validations.order_not_found'), [], 422);

        $ratingOrder = $this->order->checkRatingOrder($id);
        if (!is_null($ratingOrder))
            return $this->error(__('order::api.orders.validations.order_rated'), [], 422);

        $vendors = $order->vendors->pluck('id')->toArray() ?? [];
        $vendorId = !empty($vendors) ? $vendors[0] : null;
        $rate = $this->order->rateOrder($request, $order->id, $vendorId);
        return $this->response($rate);
    }

    public function trackOrderV2(Request $request)
    {
        $orders = $this->order->getUserTrackingOrders();
        $response = OrderResource::collection($orders);
        return $this->response($response);
    }

    public function trackOrder(Request $request)
    {
        $order = $this->order->findLastOrderOfUser();
        if (!$order)
            return $this->error(__('order::api.orders.validations.order_not_found'), [], 422);

        $orderHistories = $this->order->getOrderHistories($order->id);
        $response['order'] = new OrderResource($order);
        $response['statuses'] = OrderHistoryStatusResource::collection($orderHistories);
        return $this->response($response);
    }

    public function cancelOrder(Request $request, $id)
    {
        $order = $this->order->findById($id);
        if (!$order)
            return $this->error(__('order::api.orders.validations.order_not_found'), [], 422);

        if (is_null($order->driver)) {
            if ($order->order_status_id == 2) {
                return $this->error(__('order::api.orders.validations.order_canceled_before'), [], 422);
            } else {
                $refundedOrderStatus = 2; // refunded
                $order->update(['order_status_id' => $refundedOrderStatus]);
                $order->orderStatusesHistory()->attach([$refundedOrderStatus => ['user_id' => $order->user_id ?? null]]);
                return $this->response(null);
            }
        }
        return $this->error(__('order::api.orders.validations.order_assigned_to_driver_cannot_cancel_order'), [], 422);
    }

    public function cancelOrderV2(Request $request, $id)
    {
        if (auth('api')->guest() && is_null($request->user_token))
            return $this->error(__('order::api.orders.validations.user_token_is_required'), [], 422);

        $order = $this->order->findByIdAndUser($id, $request->user_token);
        if (!$order)
            return $this->error(__('order::api.orders.validations.order_not_found'), [], 422);

        if (is_null($order->driver)) {
            if ($order->order_status_id == 2) {
                return $this->error(__('order::api.orders.validations.order_canceled_before'), [], 422);
            } else {
                $refundedOrderStatus = 2; // refunded
                $order->update(['order_status_id' => $refundedOrderStatus]);
                $order->orderStatusesHistory()->attach([$refundedOrderStatus => ['user_id' => $order->user_id ?? null]]);
                return $this->response(null);
            }
        }
        return $this->error(__('order::api.orders.validations.order_assigned_to_driver_cannot_cancel_order'), [], 422);
    }
}
