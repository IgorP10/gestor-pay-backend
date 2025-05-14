<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Charge>
 */
class ChargeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'paid']);
        return [
            'organization_id' => Organization::factory(),
            'description' => fake()->sentence,
            'amount' => fake()->randomFloat(2, 50, 1000),
            'due_date' => fake()->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'status' => $status,
            'payment_date' => $status === 'paid' ? fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d') : null,
        ];
    }
}
