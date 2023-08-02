<?php

namespace Database\Factories;

use Carbon\Carbon;
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
            'billing_date' => $this->faker->dateTimeThisYear(),
            'medical_record_id' => 1,
            'amount' => $this->faker->randomFloat(2, 0, 999999.99),
            'insurance_provider_id' => 1,
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'rejected']),
        ];
    }
}
