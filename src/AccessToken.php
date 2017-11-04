<?php

namespace NickyWoolf\Launch;

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
            'client_id' => config('launch.client_id'),
            'client_secret' => config('launch.client_secret'),
            'code' => $code,
        ];
    }
}