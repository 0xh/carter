<?php

namespace NickyWoolf\Thrust;

use NickyWoolf\Shopify\Shopify;

class Shop
{
    protected $shopify;

    public function __construct(Shopify $shopify)
    {
        $this->shopify = $shopify;
    }

    public function get()
    {
        return $this->shopify->get('shop.json')->extract('shop');
    }

    public function setAccessToken($accessToken)
    {
        $this->shopify->setAccessToken($accessToken);

        return $this;
    }
}