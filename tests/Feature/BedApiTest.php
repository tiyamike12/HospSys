<?php

namespace Tests\Feature;

use App\Models\Bed;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BedApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_bed_record()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $bed = Bed::factory()->make()->toArray();
        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post('/api/beds', $bed);

        $response->assertStatus(201);
    }

    public function test_can_get_bed_records()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $resource = Bed::factory()->make();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/beds/' . $resource->id);

        $response->assertStatus(200);
    }

    public function test_can_update_bed_record()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $newData = [
            'ward_id' => 1,
            'patient_id' => 1,
            'bed_type' => 'free',
            'bed_status' => 'available',
            'admission_date' => '2023-10-10',
            //'discharge_date' => '2023-10-10',
        ];

        $resource = Bed::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put('/api/beds/' . $resource->id, $newData);

        $response->assertStatus(200);
    }

    public function test_can_delete_a_bed()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $resource = Bed::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete('/api/beds/' . $resource->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('beds', [
            'id' => $resource->id,
        ]);
    }
}
