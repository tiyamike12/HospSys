<?php

namespace Tests\Feature;

use App\Models\Billing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BillingApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_billing()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $data = [
            'patient_id' => 1,
            'service_date'  => '2023-10-10',
            'service_type'  => 'MedicalFee',
            'cost'  => '3000',
            'insurance_information'  => 'MASM',
            'payment_status' => 'paid',
        ];

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post('/api/billings', $data);

        $response->assertStatus(201);
    }

    public function test_can_get_billings()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $billing = Billing::factory()->create([
            'patient_id' => 1,
            'service_date' => '2023-10-10',
            'service_type' => 'Medical',
            'cost' => '2000',
            'insurance_information' => 'MASM',
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/billings/' . $billing->id);

        $response->assertStatus(200);
    }

    public function test_can_update_billing()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;
        $billing = Billing::factory()->create([
            'patient_id' => 1,
            'service_date' => '2023-10-10',
            'service_type' => 'Medical',
            'cost' => '2000',
            'insurance_information' => 'MASM',
            'payment_status' => 'paid',
        ]);

        $newData = [
            'patient_id' => 1,
            'service_date' => '2024-10-10',
            'service_type' => 'Sick',
            'cost' => '5000',
            'insurance_information' => 'Liberty',
            'payment_status' => 'paid',
        ];

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put('/api/billings/' . $billing->id, $newData);

        $response->assertStatus(200);
    }

    public function test_can_delete_billing()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $billing = Billing::factory([
            'patient_id' => 1,
            'service_date' => '2024-10-10',
            'service_type' => 'Sick',
            'cost' => '5000',
            'insurance_information' => 'Liberty',
            'payment_status' => 'paid',
        ])->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete('/api/billings/' . $billing->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('billings', [
            'id' => $billing->id,
        ]);
    }
}
