<?php

namespace NickyWoolf\Thrust;

use Illuminate\Support\ServiceProvider;
use NickyWoolf\Shopify\Request;
use NickyWoolf\Shopify\Shopify;

class ThrustServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/routes.php' => base_path('/routes/thrust.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind(Shopify::class, function () {
            return new Shopify(request('shop'));
        });

        $this->app->bind(Request::class, function () {
            return new Request(config('thrust.client_secret'));
        });
    }
}