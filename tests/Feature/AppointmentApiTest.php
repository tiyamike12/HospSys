<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppointmentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_an_appointment()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $appointment = Appointment::factory()->create([
            'patient_id' => 1,
            'user_id' => 1,
            'appointment_date_time' => '2023-10-10 15:10:21',
            'status' => 'active'
        ])->toArray();
        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post('/api/appointments', $appointment);

        $response->assertStatus(201);
    }

    public function test_can_get_an_appointment()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $appointment = Appointment::factory()->create([
            'patient_id' => 1,
            'user_id' => 1,
            'appointment_date_time' => '2023-10-10 15:10:21',
            'status' => 'active'
        ]);

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/appointments/' . $appointment->id);

        $response->assertStatus(200);
    }

    public function test_can_update_an_appointment()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;
        $appointment = Appointment::factory()->create([
            'patient_id' => 1,
            'user_id' => 1,
            'appointment_date_time' => '2023-10-10 15:10:21',
            'status' => 'active'
        ]);

        $newData = [
            'patient_id' => 2,
            'user_id' => 1,
            'appointment_date_time' => '2023-10-22 15:10:21',
            'status' => 'closed'
        ];

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put('/api/appointments/' . $appointment->id, $newData);

        $response->assertStatus(200);
    }

    public function test_can_delete_an_appointment()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $appointment = Appointment::factory()->create([
            'patient_id' => 1,
            'user_id' => 1,
            'appointment_date_time' => '2023-10-10 15:10:21',
            'status' => 'active'
        ]);

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete('/api/appointments/' . $appointment->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('appointments', [
            'id' => $appointment->id,
        ]);
    }
}
