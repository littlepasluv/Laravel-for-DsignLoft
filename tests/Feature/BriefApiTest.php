<?php

namespace Tests\Feature;

use App\Models\Brief;
use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BriefApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that authenticated users can view briefs
     */
    public function test_authenticated_users_can_view_briefs(): void
    {
        $user = User::factory()->create(['role' => 'client']);
        $package = Package::create([
            'name' => 'Test Package',
            'description' => 'Test',
            'price' => 100,
            'features' => ['test']
        ]);

        $response = $this->actingAs($user)->getJson('/api/briefs');

        $response->assertStatus(200);
    }

    /**
     * Test that authenticated users can create briefs
     */
    public function test_authenticated_users_can_create_briefs(): void
    {
        $user = User::factory()->create(['role' => 'client']);
        $package = Package::create([
            'name' => 'Test Package',
            'description' => 'Test',
            'price' => 100,
            'features' => ['test']
        ]);

        $response = $this->actingAs($user)->postJson('/api/briefs', [
            'title' => 'Test Brief',
            'description' => 'Test Description',
            'brand_style' => ['modern'],
            'colors' => ['#FF5733'],
            'package_id' => $package->id,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'brief' => ['id', 'title', 'description', 'status']
            ]);

        $this->assertDatabaseHas('briefs', [
            'title' => 'Test Brief',
            'created_by' => $user->id,
        ]);
    }

    /**
     * Test that unauthenticated users cannot access briefs
     */
    public function test_unauthenticated_users_cannot_access_briefs(): void
    {
        $response = $this->getJson('/api/briefs');

        $response->assertStatus(401);
    }
}

