<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ward>
 */
class WardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ward_name' => fake()->name(),
            'ward_type' => fake()->randomElements(['Children', 'Adult'])[0],
            'capacity' => fake()->numberBetween([30, 50]),
        ];
    }
}
