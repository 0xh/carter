<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use NickyWoolf\Thrust\Http\Middleware\Authenticate;
use NickyWoolf\Thrust\Http\Middleware\HasShopDomain;
use NickyWoolf\Thrust\Http\Middleware\HasValidHmac;
use NickyWoolf\Thrust\Http\Middleware\HasValidHostname;
use NickyWoolf\Thrust\Http\Middleware\HasValidNonce;
use NickyWoolf\Thrust\Http\Middleware\RedirectIfAuthenticated;

Route::group(['namespace' => 'NickyWoolf\\Thrust\\Http\\Controllers'], function (Router $router) {

    $router->get('shopify/login', 'AuthenticatedShopsController@store')
        ->name('thrust.login');

    $router->get('/shopify/expired_session', 'ExpiredSessionsController@index')
        ->name('thrust.expired-session');

    /**
     * Guest Routes
     */
    $router->group(['middleware' => [RedirectIfAuthenticated::class]], function (Router $router) {

        $router->get('shopify/signup', 'InstalledAppsController@create')
            ->name('thrust.signup');

        $router->match(['get', 'post'], 'shopify/install', 'InstalledAppsController@store')->middleware([
            HasShopDomain::class,
        ])->name('thrust.install');

        $router->get('shopify/register', 'RegisteredShopsController@store')->middleware([
            HasValidNonce::class,
            HasValidHmac::class,
            HasValidHostname::class,
        ])->name('thrust.register');

    });

    /**
     * Auth Routes
     */
    $router->group(['middleware' => [Authenticate::class]], function (Router $router) {

        $router->get('shopify/dashboard', 'DashboardController@index')
            ->name('thrust.dashboard');

    });
});
