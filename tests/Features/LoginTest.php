<?php

namespace Tests\Features;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tests\User;

class LoginTest extends TestCase
{
    /** @test */
    function login_user_with_shop_domain()
    {
        $this->migrate()->withFactories();
        $shop = 'example-shop.myshopify.com';
        $user = factory(User::class)->create([
            'shopify_domain' => $shop,
        ]);
        $this->assertTrue(Auth::guest());

        $response = $this->withoutExceptionHandling()->get(route('launch.login', ['shop' => $shop]));

        $response->assertRedirect(route('launch.dashboard'));
        $this->assertTrue(Auth::check());
        $this->assertTrue(Auth::user()->is($user));
    }

    /** @test */
    function redirect_to_signup_if_shop_domain_not_included()
    {
        $this->assertTrue(Auth::guest());

        $response = $this->withoutExceptionHandling()->get(route('launch.login', ['shop' => null]));

        $response->assertRedirect(route('launch.signup'));
        $this->assertTrue(Auth::guest());
    }

    /** @test */
    function redirect_to_dashboard_if_logged_in()
    {
        $this->migrate()->withFactories();
        $user = factory(User::class)->create([
            'shopify_domain' => 'example-shop.myshopify.com',
        ]);

        $response = $this->actingAs($user)->get(route('launch.login'));

        $response->assertRedirect(route('launch.dashboard'));
    }
}