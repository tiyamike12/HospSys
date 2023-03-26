<?php

namespace Tests\Feature;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MedicalRecordApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_medical_record()
    {
        $patient = Patient::factory()->create();
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $data = [
            'patient_id' => $patient->id,
            'user_id' => $user->id,
            'visit_date' => '2023-10-10',
            'diagnoses' => 'Headache',
            'lab_result_id' => 1,
            'test_results' => 'Pregnancy',
            'treatment_plan' => 'Panado',
        ];

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post('/api/medical-records', $data);

        $response->assertStatus(201);
    }

    public function test_can_get_medical_record()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $resource = MedicalRecord::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/medical-records/' . $resource->id);

        $response->assertStatus(200);
    }

    public function test_can_update_medical_record()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;
        $patient = Patient::factory()->create();

        $newData = [
            'patient_id' => $patient->id,
            'user_id' => $user->id,
            'visit_date' => '2023-10-10',
            'diagnoses' => 'Headache',
            'lab_result_id' => 1,
            'test_results' => 'Pregnancy',
            'treatment_plan' => 'Panado',
        ];

        $resource = MedicalRecord::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put('/api/medical-records/' . $resource->id, $newData);

        $response->assertStatus(200);
    }

    public function test_can_delete_a_medical_record()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;
        $resource = MedicalRecord::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete('/api/medical-records/' . $resource->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('medical_records', [
            'id' => $resource->id,
        ]);
    }
}
