<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pharmacy>
 */
class PharmacyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'medication_name' => fake()->text(30),
            'dosage' => fake()->text(30),
            'quantity' => fake()->numberBetween(300, 4000),
            'manufacturer' => fake()->text(30),
            'expiration_date' => fake()->date()
        ];
    }
}
