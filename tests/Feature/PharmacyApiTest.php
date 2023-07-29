<?php

namespace Tests\Feature;

use App\Models\PharmacyItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PharmacyApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_pharmacy_record()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $pharmacy = PharmacyItem::factory()->make()->toArray();
        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post('/api/pharmacy', $pharmacy);

        $response->assertStatus(201);
    }

    public function test_can_get_pharmacy_records()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $resource = PharmacyItem::factory()->make();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/pharmacy/' . $resource->id);

        $response->assertStatus(200);
    }

    public function test_can_update_pharmacy_record()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $newData = [
            'medication_name' => 'Panado',
            'dosage' => 'Dosage',
            'quantity' => '3000',
            'manufacturer' => 'Dell Laboratories',
            'expiration_date' => '2034-10-10'
        ];

        $resource = PharmacyItem::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put('/api/pharmacy/' . $resource->id, $newData);

        $response->assertStatus(200);
    }

    public function test_can_delete_a_pharmacy_record()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $resource = PharmacyItem::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete('/api/pharmacy/' . $resource->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('pharmacies', [
            'id' => $resource->id,
        ]);
    }
}
