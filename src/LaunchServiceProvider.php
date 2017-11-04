<?php

namespace NickyWoolf\Launch;

use Illuminate\Support\ServiceProvider;
use NickyWoolf\Shopify\Request;
use NickyWoolf\Shopify\Shopify;

class LaunchServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'launch');
        $this->mergeConfigFrom(__DIR__.'/config.php', 'launch');

        $this->publishes([
            __DIR__.'/config.php' => config_path('launch.php'),
            __DIR__.'/routes.php' => base_path('/routes/launch.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind(Shopify::class, function () {
            return new Shopify(request('shop'));
        });

        $this->app->bind(Request::class, function () {
            return new Request(config('launch.client_secret'));
        });
    }
}