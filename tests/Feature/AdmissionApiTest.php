<?php

namespace Tests\Feature;

use App\Models\Admission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdmissionApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_an_admission()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $admission = Admission::factory()->create([
            'patient_id' => 1,
            'user_id' => 1,
            'ward_id' => 1,
            'bed_id' => 1,
            'admission_date' => '2023-01-01 15:10:21',
            'status' => 'active',
        ])->toArray();
        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post('/api/admissions', $admission);

        $response->assertStatus(201);
    }

    public function test_can_get_an_admission()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $admission = Admission::factory()->create([
            'patient_id' => 1,
            'user_id' => 1,
            'ward_id' => 1,
            'bed_id' => 1,
            'admission_date' => '2023-01-01 15:10:21',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/admissions/' . $admission->id);

        $response->assertStatus(200);
    }

    public function test_can_update_an_admission()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;
        $admission = Admission::factory()->create([
            'patient_id' => 1,
            'user_id' => 1,
            'ward_id' => 1,
            'bed_id' => 1,
            'admission_date' => '2023-01-01 15:10:21',
            'status' => 'active',
        ]);

        $newData = [
            'patient_id' => 1,
            'user_id' => 1,
            'ward_id' => 1,
            'bed_id' => 2,
            'admission_date' => '2024-01-01 15:10:21',
            'admission_reason' => 'reason',
            'status' => 'closed',
        ];

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put('/api/admissions/' . $admission->id, $newData);

        $response->assertStatus(200);
    }

    public function test_can_delete_an_admission()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $admission = Admission::factory()->create([
            'patient_id' => 1,
            'user_id' => 1,
            'ward_id' => 1,
            'bed_id' => 1,
            'admission_date' => '2023-01-01 15:10:21',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete('/api/admissions/' . $admission->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('admissions', [
            'id' => $admission->id,
        ]);
    }
}
