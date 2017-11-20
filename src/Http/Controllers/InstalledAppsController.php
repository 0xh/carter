<?php

namespace NickyWoolf\Carter\Http\Controllers;

use Facades\NickyWoolf\Carter\NonceGenerator;
use NickyWoolf\Shopify\Shopify;

class InstalledAppsController extends Controller
{
    public function store(Shopify $shopify)
    {
        $nonce = tap(NonceGenerator::generate(), function ($nonce) {
            session(['carter.oauth-state' => $nonce]);
        });

        return redirect($this->authorizationUrl($shopify, $nonce));
    }

    protected function authorizationUrl($shopify, $nonce)
    {
        return $shopify->authorize(
            config('carter.client_id'), config('carter.scope'), config('carter.redirect_uri'), $nonce
        );
    }
}