<?php

namespace NickyWoolf\Thrust;

use Illuminate\Support\ServiceProvider;
use NickyWoolf\Shopify\Shopify;

class ThrustServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    public function register()
    {
        $this->app->bind(Shopify::class, function () {
            return new Shopify(request('shop'));
        });
    }
}