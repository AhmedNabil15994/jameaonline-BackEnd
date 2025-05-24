<?php

Route::post('webhooks', 'WebService\OrderController@webhooks')->name('api.orders.webhooks');

Route::group(['prefix' => 'orders'], function () {

    Route::post('create', 'WebService\OrderController@createOrder')->name('api.orders.create');

    Route::get('success', 'WebService\OrderController@success')
        ->name('api.orders.success');

    Route::get('failed', 'WebService\OrderController@failed')
        ->name('api.orders.failed');


    Route::group(['prefix' => '/', 'middleware' => 'auth:api'], function () {

        Route::get('list', 'WebService\OrderController@userOrdersList')->name('api.orders.index');
        Route::get('{id}/details', 'WebService\OrderController@getOrderDetails')->name('api.orders.details');
        Route::post('{id}/rates', 'WebService\OrderController@rateOrder')->name('api.orders.rates');
        Route::get('{id}/order-statuses', 'WebService\OrderController@getOrderStatuses')->name('api.orders.statuses');
        Route::get('track-order', 'WebService\OrderController@trackOrder')->name('api.orders.track_order');
        Route::get('v2/track-order', 'WebService\OrderController@trackOrderV2')->name('api.v2.orders.track_order');
    });

    Route::post('{id}/cancel-order', 'WebService\OrderController@cancelOrder')->name('api.orders.cancel_order');
    Route::post('v2/{id}/cancel-order', 'WebService\OrderController@cancelOrderV2')->name('api.orders.cancel_order.v2');
    Route::post('{id}/reorder/create', 'WebService\ReOrderController@reOrder')->name('api.orders.reorder');
});
