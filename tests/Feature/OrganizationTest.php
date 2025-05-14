<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganizationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_create_organization()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->postJson('/api/organizations', [
            'name' => 'Test Org',
            'email' => 'org@example.com',
            'phone' => '123456789',
        ]);

        $response->assertStatus(201)->assertJsonFragment(['name' => 'Test Org']);
    }
}
