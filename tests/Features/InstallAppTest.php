<?php

namespace Tests\Features;

use Facades\NickyWoolf\Thrust\NonceGenerator;
use Tests\TestCase;

class InstallAppTest extends TestCase
{
    /** @test */
    function request_access_to_shopify_shop_as_first_step()
    {
        config()->set('thrust', [
            'client_id' => 'CLIENT-ID',
            'redirect_uri' => 'REDIRECT-URL',
            'scope' => ['READ', 'WRITE'],
        ]);
        NonceGenerator::shouldReceive('generate')->andReturn('RANDOM-NONCE');

        $response = $this->withoutExceptionHandling()->get(route('thrust.install', [
            'shop' => 'example.myshopify.com',
        ]));

        $response->assertRedirect();
        $url = parse_url($response->headers->get('Location'));
        parse_str($url['query'], $query);
        $this->assertEquals(
            'https://example.myshopify.com/admin/oauth/authorize', "{$url['scheme']}://{$url['host']}{$url['path']}"
        );
        $this->assertEquals('CLIENT-ID', $query['client_id']);
        $this->assertEquals('REDIRECT-URL', $query['redirect_uri']);
        $this->assertEquals('READ,WRITE', $query['scope']);
        $this->assertEquals('RANDOM-NONCE', $query['state']);
        $this->assertEquals('RANDOM-NONCE', session('thrust.oauth-state'));
    }
}