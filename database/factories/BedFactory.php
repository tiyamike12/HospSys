<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bed>
 */
class BedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ward_id' => 1,
            'patient_id' => 1,
            'bed_type' => fake()->randomElements(['paid', 'free'])[0],
            'bed_status' => fake()->randomElements(['available', 'occupied'])[0],
            'admission_date' => '2023-10-10',
            'discharge_date' => '2023-10-13',
        ];
    }
}
