<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Billing>
 */
class BillingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => 1,
            'service_date' => fake()->date,
            'service_type' => fake()->text(10),
            'cost' => fake()->randomFloat(6),
            'insurance_information' => fake()->text(50),
            'payment_status' => fake()->randomElements(['pending', 'paid']),
        ];
    }
}
