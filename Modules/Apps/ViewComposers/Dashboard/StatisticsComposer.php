<?php

namespace Modules\Apps\ViewComposers\Dashboard;

use Modules\Order\Repositories\Dashboard\OrderRepository as Order;
use Modules\Catalog\Repositories\Dashboard\ProductRepository as Product;
use Modules\Vendor\Repositories\Dashboard\VendorRequestRepository as VendorRequestRepo;
use Illuminate\View\View;

class StatisticsComposer
{
    public $ordersCount = [];
    public $reviewProductsCount = [];
    public $vendorRequestsCount = [];

    public function __construct(Order $order, Product $product, VendorRequestRepo $vendorRequestRepo)
    {
        $this->ordersCount['current_orders'] = $order->getOrdersCountByFlag('current_orders');
        $this->reviewProductsCount = $product->getReviewProductsCount();
        $this->vendorRequestsCount = $vendorRequestRepo->getVendorRequestsCount();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'ordersCount' => $this->ordersCount,
            'reviewProductsCount' => $this->reviewProductsCount,
            'vendorRequestsCount' => $this->vendorRequestsCount,
        ]);
    }
}
