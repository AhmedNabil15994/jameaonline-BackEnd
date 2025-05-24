<?php

view()->composer(
    [
        'order::dashboard.orders.index',
        'order::dashboard.all_orders.index',
        'order::dashboard.completed_orders.index',
        'order::dashboard.not_completed_orders.index',
        'order::dashboard.refunded_orders.index',
        'setting::dashboard.tabs.*',
    ],
    \Modules\Order\ViewComposers\Dashboard\OrderStatusComposer::class
);
