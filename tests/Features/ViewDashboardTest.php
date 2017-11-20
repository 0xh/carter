<?php

namespace Tests\Features;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tests\User;

class ViewDashboardTest extends TestCase
{
    /** @test */
    function logged_in_user_can_view_dashboard()
    {
        $this->migrate()->withFactories();
        $user = factory(User::class)->create();

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get(route('carter.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('carter::embedded.dashboard');
    }

    /** @test */
    function guests_with_shop_domain_redirected_to_login()
    {
        $this->migrate()->withFactories();
        $this->assertTrue(Auth::guest());

        $response = $this->withoutExceptionHandling()->get(route('carter.dashboard', [
            'shop' => 'example-shop.myshopify.com',
        ]));

        $response->assertRedirect(route('carter.login', ['shop' => 'example-shop.myshopify.com']));
    }

    /** @test */
    function guests_without_shop_domain_see_expired_session_view()
    {
        $this->migrate()->withFactories();
        $this->assertTrue(Auth::guest());

        $response = $this->withoutExceptionHandling()->get(route('carter.dashboard', [
            'shop' => null,
        ]));

        $response->assertRedirect(route('carter.expired-session'));
    }
}