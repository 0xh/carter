<?php

namespace NickyWoolf\Carter;

use Illuminate\Support\ServiceProvider;
use NickyWoolf\Shopify\Request;
use NickyWoolf\Shopify\Shopify;

class CarterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'carter');
        $this->mergeConfigFrom(__DIR__.'/config.php', 'carter');

        $this->publishes([
            __DIR__.'/config.php' => config_path('carter.php'),
            __DIR__.'/routes.php' => base_path('/routes/carter.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind(Shopify::class, function () {
            return new Shopify(request('shop'));
        });

        $this->app->bind(Request::class, function () {
            return new Request(config('carter.client_secret'));
        });
    }
}