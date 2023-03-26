<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    protected $model = Patient::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'gender' => fake()->randomElements(['male', 'female'])[0],
            'date_of_birth' => fake()->date(),
            'phone' => fake()->phoneNumber,
            'email' => fake()->email(),
            'physical_address' => fake()->address(),
            'insurance_information' => fake()->text(50)
        ];
    }
}
