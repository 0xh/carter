<?php

namespace NickyWoolf\Thrust\Http\Controllers;

use Facades\NickyWoolf\Thrust\NonceGenerator;
use NickyWoolf\Shopify\Shopify;

class InstalledAppsController extends Controller
{
    public function store(Shopify $shopify)
    {
        $nonce = tap(NonceGenerator::generate(), function ($nonce) {
            session(['thrust.oauth-state' => $nonce]);
        });

        return redirect($this->authorizationUrl($shopify, $nonce));
    }

    protected function authorizationUrl($shopify, $nonce)
    {
        return $shopify->authorize(
            config('thrust.client_id'), config('thrust.scope'), config('thrust.redirect_uri'), $nonce
        );
    }
}