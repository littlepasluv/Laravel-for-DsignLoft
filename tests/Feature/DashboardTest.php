<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that client users can access client dashboard
     */
    public function test_client_users_can_access_client_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'client']);

        $response = $this->actingAs($user)->get('/dashboard/client');

        $response->assertStatus(200);
    }

    /**
     * Test that designer users can access designer dashboard
     */
    public function test_designer_users_can_access_designer_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'designer']);

        $response = $this->actingAs($user)->get('/dashboard/designer');

        $response->assertStatus(200);
    }

    /**
     * Test that admin users can access admin dashboard
     */
    public function test_admin_users_can_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get('/dashboard/admin');

        $response->assertStatus(200);
    }

    /**
     * Test that client users cannot access admin dashboard
     */
    public function test_client_users_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'client']);

        $response = $this->actingAs($user)->get('/dashboard/admin');

        $response->assertStatus(403);
    }

    /**
     * Test that dashboard redirects based on role
     */
    public function test_dashboard_redirects_based_on_role(): void
    {
        $client = User::factory()->create(['role' => 'client']);
        
        $response = $this->actingAs($client)->get('/dashboard');
        
        $response->assertRedirect('/dashboard/client');
    }
}

