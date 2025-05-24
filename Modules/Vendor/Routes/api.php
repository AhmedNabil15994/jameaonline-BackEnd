<?php


Route::group(['prefix' => 'vendors'], function () {

    Route::get('categories', 'WebService\VendorController@categories')->name('api.vendors.categories');
    Route::get('delivery-charge', 'WebService\VendorController@deliveryCharge');
    Route::get('sections', 'WebService\VendorController@sections');
    Route::get('/', 'WebService\VendorController@vendors');
    Route::get('/{id}', 'WebService\VendorController@getVendorById')->name('api.get_one_vendor');
    Route::get('vendor/work-times', 'WebService\VendorController@getVendorWorkTimes')->name('api.get_vendor_work_times');
    Route::get('vendor/delivery-times', 'WebService\VendorController@getVendorDeliveryTimes')->name('api.get_vendor_delivery_times');
    Route::get('vendor/delivery-times/v2', 'WebService\VendorController@getVendorDeliveryTimesV2')->name('api.get_vendor_delivery_times.v2');

    Route::group(['prefix' => 'v2'], function () {
        Route::get('{id}/details', 'WebService\VendorController@getVendorDetailsByIdV2')->name('api.get_vendor_details');
        Route::get('{id}/product-categories', 'WebService\VendorController@getVendorProductCategoriesByIdV2')->name('api.get_vendor_product_categories');
    });

    Route::post('join-us', 'WebService\VendorRequestController@createVendorRequest');

    Route::group(['prefix' => '/', 'middleware' => 'auth:api'], function () {
        Route::post('rate', 'WebService\VendorController@vendorRate')->name('api.vendors.rate');
    });

    /*Route::group(['prefix' => 'delivery-companies'], function () {

        Route::get('{id}', 'WebService\VendorController@getVendorDeliveryCompanies');

    });*/
});
