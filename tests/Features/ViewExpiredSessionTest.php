<?php

namespace Tests\Features;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tests\User;

class ViewExpiredSessionTest extends TestCase
{
    /** @test */
    function guest_without_shop_domain_can_view_expired_session()
    {
        $this->assertTrue(Auth::guest());

        $response = $this->withoutExceptionHandling()->get(route('thrust.expired-session'));

        $response->assertViewIs('thrust::embedded.expired-session');
    }

    /** @test */
    function logged_in_user_redirected_to_dashboard()
    {
        $this->migrate()->withFactories();
        $user = factory(User::class)->create();

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get(route('thrust.expired-session'));

        $response->assertRedirect(route('thrust.dashboard'));
    }
}