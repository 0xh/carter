<?php

namespace Tests\Unit;

use Mockery;
use NickyWoolf\Shopify\Shopify;
use NickyWoolf\Thrust\Shop;
use Tests\TestCase;

class ShopTest extends TestCase
{
    /** @test */
    function get_shop_resource_from_shopify()
    {
        $shopify = Mockery::mock(Shopify::class);
        $shopify->shouldReceive('get')->with('shop.json')->once()->andReturnSelf();
        $shopify->shouldReceive('extract')->with('shop')->once()->andReturn('SHOP-RESOURCE');
        $shop = new Shop($shopify);

        $this->assertEquals('SHOP-RESOURCE', $shop->get());
    }

    /** @test */
    function set_shopify_access_token()
    {
        $shopify = Mockery::mock(Shopify::class);
        $shop = new Shop($shopify);
        $shopify->shouldReceive('setAccessToken')->with('ACCESS-TOKEN')->once();

        $this->assertEquals($shop, $shop->setAccessToken('ACCESS-TOKEN'));
    }
}