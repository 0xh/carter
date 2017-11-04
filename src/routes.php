<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use NickyWoolf\Launch\Http\Middleware\Authenticate;
use NickyWoolf\Launch\Http\Middleware\HasShopDomain;
use NickyWoolf\Launch\Http\Middleware\HasValidHmac;
use NickyWoolf\Launch\Http\Middleware\HasValidHostname;
use NickyWoolf\Launch\Http\Middleware\HasValidNonce;
use NickyWoolf\Launch\Http\Middleware\RedirectIfAuthenticated;

Route::group(['namespace' => 'NickyWoolf\\Launch\\Http\\Controllers'], function (Router $router) {

    /* Guest Routes */
    $router->group(['middleware' => [RedirectIfAuthenticated::class]], function (Router $router) {

        $router->get('shopify/signup', 'InstalledAppsController@create')->name('launch.signup');

        $router->match(['get', 'post'], 'shopify/install', 'InstalledAppsController@store')->middleware([
            HasShopDomain::class,
        ])->name('launch.install');

        $router->get('shopify/register', 'RegisteredShopsController@store')->middleware([
            HasValidNonce::class,
            HasValidHmac::class,
            HasValidHostname::class,
        ])->name('launch.register');

        $router->get('shopify/login', 'AuthenticatedShopsController@store')->middleware([
            HasShopDomain::class,
        ])->name('launch.login');

        $router->get('/shopify/expired_session', 'ExpiredSessionsController@index')->name('launch.expired-session');

    });

    /* Auth Routes */
    $router->group(['middleware' => [Authenticate::class]], function (Router $router) {

        $router->get('shopify/dashboard', 'DashboardController@index')->name('launch.dashboard');

    });

});
