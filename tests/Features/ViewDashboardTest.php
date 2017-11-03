<?php

namespace Tests\Features;

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
            ->get(route('thrust.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('thrust::embedded.dashboard');
    }
}