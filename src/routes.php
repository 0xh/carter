<?php

Route::group(['namespace' => 'NickyWoolf\\Thrust\\Http\\Controllers'], function () {

    Route::get('/shopify/install', 'InstalledAppsController@store')->name('thrust.install');

});
