<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Charge;
use App\Models\Organization;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargeTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    public function test_can_list_charges()
    {
        $user = User::factory()->create();
        $org = Organization::factory()->create();
        Charge::factory()->count(3)->create(['organization_id' => $org->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/charges');
        $response->assertStatus(200)->assertJsonCount(3);
    }
}
