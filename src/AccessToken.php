<?php

namespace NickyWoolf\Thrust;

use NickyWoolf\Shopify\Shopify;

class AccessToken
{
    protected $shopify;

    public function __construct(Shopify $shopify)
    {
        $this->shopify = $shopify;
    }

    public function request($code)
    {
        return $this->shopify->post('oauth/access_token', $this->requestData($code))->json();
    }

    protected function requestData($code)
    {
        return [
            'client_id' => config('thrust.client_id'),
            'client_secret' => config('thrust.client_secret'),
            'code' => $code,
        ];
    }
}