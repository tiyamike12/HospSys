<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Ward;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WardApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_ward()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $ward = Ward::factory()->make()->toArray();
        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post('/api/wards', $ward);

        $response->assertStatus(201);
    }

    public function test_can_get_ward()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $resource = Ward::factory()->make();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/wards/' . $resource->id);

        $response->assertStatus(200);
    }

    public function test_can_update_ward()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $newData = [
            'ward_name' => 'Kapeni',
            'ward_type' => 'Children',
            'capacity' => 50,
        ];

        $resource = Ward::factory()->create([
            'ward_name' => 'Nyika',
            'ward_type' => 'Adult',
            'capacity' => 30,
        ]);

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put('/api/wards/' . $resource->id, $newData);

        $response->assertStatus(200);
    }

    public function test_can_delete_a_ward()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $resource = Ward::factory()->create([
            'ward_name' => 'Kapeni',
            'ward_type' => 'Children',
            'capacity' => 50,
        ]);

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete('/api/wards/' . $resource->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('wards', [
            'id' => $resource->id,
        ]);
    }
}
