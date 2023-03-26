<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatientApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_patient()
    {
        $patient = Patient::factory()->create()->toArray();
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post('/api/patients', $patient);

        $response->assertStatus(201);
    }

    public function test_can_get_patient()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $resource = Patient::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/patients/' . $resource->id);

        $response->assertStatus(200);
    }

    public function test_can_update_patient()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $newData = [
            'firstname' => 'Tiyamike',
            'surname' => 'Nkhono',
            'gender' => 'male',
            'date_of_birth' => '20-04-2000',
            'phone' => '0992443343',
            'email' => 'tiya@gmail.com',
            'physical_address' => 'Ndirande',
            'insurance_information' => 'MASM Premium'
        ];

        $resource = Patient::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put('/api/patients/' . $resource->id, $newData);

        $response->assertStatus(200);
    }

    public function test_can_delete_a_patient()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $resource = Patient::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete('/api/patients/' . $resource->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('patients', [
            'id' => $resource->id,
        ]);
    }
}
