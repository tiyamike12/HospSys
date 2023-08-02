<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => 6,
            'user_id' => 2,
            'appointment_date' => fake()->date('Y-m-d'),
            'appointment_time' => fake()->time('H:i:s'),
            'purpose' => fake()->text(20),
            'status' => fake()->text(10),
        ];
    }
}
