<?php

Route::group(['prefix' => 'p'], function () {

    Route::get('{slug}', 'FrontEnd\PageController@page')->name('frontend.pages.index');

});

Route::get('privacy-policy', 'FrontEnd\PageController@getPrivacyPolicyPage')->name('frontend.pages.privacy_policy');

