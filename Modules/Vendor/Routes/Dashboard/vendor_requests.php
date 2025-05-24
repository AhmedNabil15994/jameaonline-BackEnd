<?php

Route::group(['prefix' => 'vendor-requests'], function () {

  	Route::get('/' ,'Dashboard\VendorRequestController@index')
  	->name('dashboard.vendor_requests.index')
    ->middleware(['permission:show_vendor_requests']);

  	Route::get('datatable'	,'Dashboard\VendorRequestController@datatable')
  	->name('dashboard.vendor_requests.datatable')
  	->middleware(['permission:show_vendor_requests']);

  	Route::delete('{id}'	,'Dashboard\VendorRequestController@destroy')
  	->name('dashboard.vendor_requests.destroy')
    ->middleware(['permission:delete_vendor_requests']);

  	Route::get('deletes'	,'Dashboard\VendorRequestController@deletes')
  	->name('dashboard.vendor_requests.deletes')
    ->middleware(['permission:delete_vendor_requests']);

  	Route::get('{id}','Dashboard\VendorRequestController@show')
  	->name('dashboard.vendor_requests.show')
    ->middleware(['permission:show_vendor_requests']);

});
