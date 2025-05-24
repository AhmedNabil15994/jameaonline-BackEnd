<?php

// DASHBOARD VIEW COMPOSER
view()->composer(['vendor::dashboard.vendors.*'], \Modules\Vendor\ViewComposers\Dashboard\PaymentComposer::class);
view()->composer(
    [
        'vendor::dashboard.vendors.*',
        'catalog::dashboard.categories.*',
    ],
    \Modules\Vendor\ViewComposers\Dashboard\SectionComposer::class
);
view()->composer(['vendor::dashboard.vendors.*', 'apps::vendor.*'], \Modules\Vendor\ViewComposers\Dashboard\VendorStatusComposer::class);

view()->composer(
    [
        'setting::dashboard.tabs.*',
        'subscription::dashboard.subscriptions.*',
        'catalog::dashboard.products.review-products.*',
        'catalog::dashboard.products.index',
        'catalog::dashboard.products.create',
        'catalog::dashboard.products.clone',
        'catalog::dashboard.products.edit',
        //  'vendor::dashboard.delivery-charges.*',
        'coupon::dashboard.*',
        'order::dashboard.orders.index',
        'order::dashboard.all_orders.index',
        'order::dashboard.completed_orders.index',
        'order::dashboard.not_completed_orders.index',
        'order::dashboard.refunded_orders.index',
        "report::dashboard.reports.*",
    ],
    \Modules\Vendor\ViewComposers\Dashboard\VendorComposer::class
);


// FRONTEND VIEW COMPOSER
view()->composer(
    [
        'apps::frontend.layouts._header',
        'apps::frontend.layouts._footer'
    ],
    \Modules\Vendor\ViewComposers\FrontEnd\SectionComposer::class
);

view()->composer(
    [
        'vendor::frontend.vendors.sidebar.filter'
    ],
    \Modules\Vendor\ViewComposers\FrontEnd\PaymentsComposer::class
);

view()->composer(
    [
        'vendor::frontend.vendors.sidebar.filter',
    ],
    \Modules\Vendor\ViewComposers\FrontEnd\VendorStatusComposer::class
);

// VENDOR DASHBOARD VIEW COMPOSER
view()->composer(['apps::vendor.index'], \Modules\Vendor\ViewComposers\Vendor\VendorComposer::class);

view()->composer(
    [
        'catalog::vendor.products.create',
        'catalog::vendor.products.edit',
        'catalog::vendor.products.clone',
    ],
    \Modules\Vendor\ViewComposers\Vendor\VendorComposer::class
);

// Dashboard ViewComposer
view()->composer([
    'vendor::dashboard.categories.*',
    'vendor::dashboard.vendors.*',
    /*'advertising::dashboard.advertising.*',
    'notification::dashboard.notifications.*',
    'slider::dashboard.sliders.*',
    'coupon::dashboard.*',*/
], \Modules\Vendor\ViewComposers\Dashboard\CategoryComposer::class);
