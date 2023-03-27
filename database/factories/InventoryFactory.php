<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_name' => fake()->text(100),
            'item_description' => fake()->text(100),
            'quantity' => fake()->numberBetween(1000, 20000),
            'supplier' => fake()->text(40),
            'cost' => fake()->randomElements(['30000', '90000'])[0],
        ];
    }
}
