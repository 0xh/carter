<?php

namespace Tests\Features;

use Facades\NickyWoolf\Thrust\NonceGenerator;
use Tests\TestCase;
use Tests\User;

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

    /** @test */
    function install_route_handles_post_request()
    {
        config()->set('thrust', [
            'client_id' => 'CLIENT-ID',
            'redirect_uri' => 'REDIRECT-URL',
            'scope' => ['READ', 'WRITE'],
        ]);
        NonceGenerator::shouldReceive('generate')->andReturn('RANDOM-NONCE');

        $response = $this->withoutExceptionHandling()->post(route('thrust.install', [
            'shop' => 'example.myshopify.com',
        ]));

        $url = parse_url($response->headers->get('Location'));
        $this->assertEquals(
            'https://example.myshopify.com/admin/oauth/authorize', "{$url['scheme']}://{$url['host']}{$url['path']}"
        );
    }

    /** @test */
    function redirect_to_sign_up_form_if_shop_domain_missing()
    {
        $response = $this->withoutExceptionHandling()->get(route('thrust.install', [
            'shop' => null,
        ]));

        $response->assertRedirect(route('thrust.signup'));
    }

    /** @test */
    function redirect_from_signup_if_logged_in()
    {
        $this->migrate()->withFactories();
        $user = factory(User::class)->create();

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get(route('thrust.signup', [
                'shop' => 'example.myshopify.com',
            ]));

        $response->assertRedirect(route('thrust.dashboard'));
    }

    /** @test */
    function redirect_from_install_if_logged_in()
    {
        $this->migrate()->withFactories();
        $user = factory(User::class)->create();

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get(route('thrust.install', [
                'shop' => 'example.myshopify.com',
            ]));

        $response->assertRedirect(route('thrust.dashboard'));
    }
}