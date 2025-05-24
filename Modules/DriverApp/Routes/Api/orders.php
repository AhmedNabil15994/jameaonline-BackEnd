<?php

Route::group(['prefix' => 'orders', 'middleware' => 'IsDriver', 'namespace' => 'WebService\Orders'], function () {
    Route::get('list', 'OrderController@index')->name('api.driver.orders.index');
    Route::get('list/{id}', 'OrderController@show')->name('api.driver.orders.show');
    Route::post('update-status/{id}', 'OrderController@updateOrderStatus')->name('api.driver.orders.update_status');
});

