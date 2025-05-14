<?php

namespace Database\Seeders;

use App\Models\Charge;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organization::all()->each(function ($org) {
            Charge::factory()->count(5)->create([
                'organization_id' => $org->id,
                'status' => fake()->randomElement(['paid', 'pending']),
            ]);
        });
    }
}
