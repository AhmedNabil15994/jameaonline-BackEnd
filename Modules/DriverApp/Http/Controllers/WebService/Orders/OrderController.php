<?php

namespace Modules\DriverApp\Http\Controllers\WebService\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\DriverApp\Transformers\WebService\OrderResource;
use Modules\DriverApp\Repositories\WebService\OrderRepository as Order;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;

class OrderController extends WebServiceController
{
    protected $order;

    function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index(Request $request)
    {
        $orders = $this->order->getAllByDriver();
        return $this->response(OrderResource::collection($orders));
    }

    public function show(Request $request, $id)
    {
        $order = $this->order->findDriverOrderById($id);
        if (!$order)
            return $this->error(__('driver_app::orders.driver.order_not_found'), [], 401);

        return $this->response(new OrderResource($order));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = $this->order->findDriverOrderById($id);
        if (!$order)
            return $this->error(__('driver_app::orders.driver.order_not_found'), [], 401);

        $check = $this->order->updateOrderByDriver($order, $request, $id);
        if ($check)
            return $this->response(null);
        else
            return $this->error(__('driver_app::orders.driver.oops_error'), [], 401);
    }

}
