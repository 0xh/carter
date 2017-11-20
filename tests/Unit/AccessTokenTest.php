<?php

namespace Tests\Unit;

use Mockery;
use NickyWoolf\Shopify\Shopify;
use NickyWoolf\Carter\AccessToken;
use Tests\TestCase;

class AccessTokenTest extends TestCase
{
    /** @test */
    function makes_request_to_shopify()
    {
        config()->set('carter', [
            'client_id' => 'CLIENT-ID',
            'client_secret' => 'CLIENT-SECRET',
        ]);
        $shopify = Mockery::mock(Shopify::class);
        $accessToken = new AccessToken($shopify);
        $shopify->shouldReceive('post')->with('oauth/access_token', [
            'client_id' => 'CLIENT-ID',
            'client_secret' => 'CLIENT-SECRET',
            'code' => 'CODE-FROM-SHOPIFY',
        ])->once()->andReturnSelf();
        $shopify->shouldReceive('json')->once()->andReturn([
            'access_token' => 'ACCESS-TOKEN',
            'scope' => 'READ,WRITE',
        ]);

        $response = $accessToken->request('CODE-FROM-SHOPIFY');

        $this->assertEquals([
            'access_token' => 'ACCESS-TOKEN',
            'scope' => 'READ,WRITE',
        ], $response);
    }
}