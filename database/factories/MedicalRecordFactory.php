<?php

namespace Database\Factories;

use App\Models\MedicalRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    protected $model = MedicalRecord::class;
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
            'visit_date' => fake()->date,
            'diagnoses' => fake()->text(100),
            'lab_result_id' => 1,
            'test_results' => fake()->text(100),
            'treatment_plan' => fake()->text(100),
        ];
    }
}
