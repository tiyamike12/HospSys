<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admission>
 */
class AdmissionFactory extends Factory
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
            'user_id' => 1,
            'ward_id' => 1,
            'bed_id' => 1,
            'admission_date' => '2023-01-01',
            'discharge_date' => '2023-10-10',
            'admission_reason' => fake()->text(50),
            'discharge_reason' => fake()->text(50),
            'status' => fake()->randomElements(['active', 'closed']),
        ];
    }
}
