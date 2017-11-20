<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use NickyWoolf\Carter\Http\Middleware\Authenticate;
use NickyWoolf\Carter\Http\Middleware\HasShopDomain;
use NickyWoolf\Carter\Http\Middleware\HasValidHmac;
use NickyWoolf\Carter\Http\Middleware\HasValidHostname;
use NickyWoolf\Carter\Http\Middleware\HasValidNonce;
use NickyWoolf\Carter\Http\Middleware\RedirectIfAuthenticated;

Route::group(['namespace' => 'NickyWoolf\\Carter\\Http\\Controllers'], function (Router $router) {

    /* Guest Routes */
    $router->group(['middleware' => [RedirectIfAuthenticated::class]], function (Router $router) {

        $router->get('shopify/signup', 'InstalledAppsController@create')->name('carter.signup');

        $router->match(['get', 'post'], 'shopify/install', 'InstalledAppsController@store')->middleware([
            HasShopDomain::class,
        ])->name('carter.install');

        $router->get('shopify/register', 'RegisteredShopsController@store')->middleware([
            HasValidNonce::class,
            HasValidHmac::class,
            HasValidHostname::class,
        ])->name('carter.register');

        $router->get('shopify/login', 'AuthenticatedShopsController@store')->middleware([
            HasShopDomain::class,
        ])->name('carter.login');

        $router->get('/shopify/expired_session', 'ExpiredSessionsController@index')->name('carter.expired-session');

    });

    /* Auth Routes */
    $router->group(['middleware' => [Authenticate::class]], function (Router $router) {

        $router->get('shopify/dashboard', 'DashboardController@index')->name('carter.dashboard');

    });

});
