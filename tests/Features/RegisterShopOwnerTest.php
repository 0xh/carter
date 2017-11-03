<?php

namespace Tests\Features;

use Facades\NickyWoolf\Thrust\AccessToken;
use Facades\NickyWoolf\Thrust\Shop;
use Illuminate\Support\Facades\Auth;
use NickyWoolf\Shopify\Request;
use Tests\TestCase;

class RegisterShopOwnerTest extends TestCase
{
    /** @test */
    function register_shop_after_access_granted()
    {
        $this->migrate();
        session(['thrust.oauth-state' => 'RANDOM-NONCE']);
        config()->set('thrust', [
            'client_secret' => 'SHOPIFY-CLIENT-SECRET',
            'scope' => ['READ', 'WRITE'],
        ]);
        $request = [
            'shop' => 'example.myshopify.com',
            'code' => 'SHOPIFY-OAUTH-CODE',
            'state' => 'RANDOM-NONCE',
        ];
        $request['hmac'] = app(Request::class)->sign($request);
        AccessToken::shouldReceive('request')
            ->with('SHOPIFY-OAUTH-CODE')
            ->once()
            ->andReturn([
                'access_token' => 'SHOPIFY-TOKEN',
                'scope' => 'READ,WRITE',
            ]);
        Shop::shouldReceive('get')
            ->with('SHOPIFY-TOKEN')
            ->once()
            ->andReturn([
                'id' => 1234567890,
                'name' => 'Example Shop',
                'email' => 'emily@example-shop.com',
                'myshopify_domain' => 'example.myshopify.com',
            ]);

        $response = $this->withoutExceptionHandling()->get(route('thrust.register', $request));

        $response->assertRedirect(route('thrust.dashboard'));
        $this->assertTrue(Auth::check());
        $user = Auth::user();
        $this->assertEquals('Example Shop', $user->name);
        $this->assertEquals('emily@example-shop.com', $user->email);
        $this->assertEquals(1234567890, $user->shopify_id);
        $this->assertEquals('example.myshopify.com', $user->shopify_domain);
        $this->assertEquals('SHOPIFY-TOKEN', $user->shopify_token);
        $this->assertEquals('READ,WRITE', $user->shopify_scope);
        $this->assertNull($user->shopify_charge_id);
    }

    /** @test */
    function abort_registration_if_nonce_doesnt_match()
    {
        config('thrust.client_secret', 'VALID-CLIENT-SECRET');
        session(['thrust.oauth-state' => 'THE-CORRECT-NONCE']);
        $request= ['state' => 'AN-INVALID-NONCE'];
        $request['hmac'] = app(Request::class)->sign($request);

        $response = $this->get(route('thrust.register', $request));

        $response->assertStatus(403);
    }

    /** @test */
    function abort_registration_if_nonce_is_an_empty_string()
    {
        config('thrust.client_secret', 'VALID-CLIENT-SECRET');
        session(['thrust.oauth-state' => '']);
        $request= ['state' => ''];
        $request['hmac'] = app(Request::class)->sign($request);

        $response = $this->get(route('thrust.register', $request));

        $response->assertStatus(403);
    }

    /** @test */
    function abort_registration_if_stored_nonce_is_null()
    {
        config('thrust.client_secret', 'VALID-CLIENT-SECRET');
        session(['thrust.oauth-state' => null]);
        $request= ['state' => null];
        $request['hmac'] = app(Request::class)->sign($request);

        $response = $this->get(route('thrust.register', $request));

        $response->assertStatus(403);
    }

    /** @test */
    function abort_registration_if_hmac_validation_fails()
    {
        config('thrust.client_secret', 'VALID-CLIENT-SECRET');
        session(['thrust.oauth-state' => 'THE-CORRECT-NONCE']);
        $request= ['state' => 'THE-CORRECT-NONCE'];
        $request['hmac'] = (new Request('INVALID-CLIENT-SECRET'))->sign($request);

        $response = $this->get(route('thrust.register', $request));

        $response->assertStatus(403);
    }

    /** @test */
    function abort_registration_if_shop_domain_contains_special_characters()
    {
        config('thrust.client_secret', 'VALID-CLIENT-SECRET');
        session(['thrust.oauth-state' => 'RANDOM-NONCE']);
        $request = [
            'shop' => '$example().myshopify.com',
            'code' => 'SHOPIFY-OAUTH-CODE',
            'state' => 'RANDOM-NONCE',
        ];
        $request['hmac'] = app(Request::class)->sign($request);

        $response = $this->get(route('thrust.register', $request));

        $response->assertStatus(403);
    }

    /** @test */
    function abort_registration_if_shop_domain_doesnt_end_in_myshopify_dot_com()
    {
        config('thrust.client_secret', 'VALID-CLIENT-SECRET');
        session(['thrust.oauth-state' => 'RANDOM-NONCE']);
        $request = [
            'shop' => 'example-shop.com',
            'code' => 'SHOPIFY-OAUTH-CODE',
            'state' => 'RANDOM-NONCE',
        ];
        $request['hmac'] = app(Request::class)->sign($request);

        $response = $this->get(route('thrust.register', $request));

        $response->assertStatus(403);
    }
}