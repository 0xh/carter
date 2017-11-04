<?php

namespace NickyWoolf\Launch\Http\Controllers;

use Facades\NickyWoolf\Launch\NonceGenerator;
use NickyWoolf\Shopify\Shopify;

class InstalledAppsController extends Controller
{
    public function store(Shopify $shopify)
    {
        $nonce = tap(NonceGenerator::generate(), function ($nonce) {
            session(['launch.oauth-state' => $nonce]);
        });

        return redirect($this->authorizationUrl($shopify, $nonce));
    }

    protected function authorizationUrl($shopify, $nonce)
    {
        return $shopify->authorize(
            config('launch.client_id'), config('launch.scope'), config('launch.redirect_uri'), $nonce
        );
    }
}