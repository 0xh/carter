<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use NickyWoolf\Thrust\Http\Middleware\HasShopDomain;

Route::group(['namespace' => 'NickyWoolf\\Thrust\\Http\\Controllers'], function (Router $router) {

    $router->get('shopify/signup', 'InstalledAppsController@create')
        ->name('thrust.signup');

    $router->match(['get', 'post'], 'shopify/install', 'InstalledAppsController@store')
        ->middleware([HasShopDomain::class])
        ->name('thrust.install');

});
