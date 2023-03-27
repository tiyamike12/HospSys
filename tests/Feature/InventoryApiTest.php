<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InventoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_inventory_record()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $inventory = Inventory::factory()->make()->toArray();
        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post('/api/inventories', $inventory);

        $response->assertStatus(201);
    }

    public function test_can_get_inventory_records()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $resource = Inventory::factory()->make();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/inventories/' . $resource->id);

        $response->assertStatus(200);
    }

    public function test_can_update_inventory_record()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $newData = [
            'item_name' => 'Chair',
            'item_description' => 'Chairs for patients',
            'quantity' => 3000,
            'supplier' => 'Poly',
            'cost' => '30000',
        ];

        $resource = Inventory::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put('/api/inventories/' . $resource->id, $newData);

        $response->assertStatus(200);
    }

    public function test_can_delete_an_inventory()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $resource = Inventory::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete('/api/inventories/' . $resource->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('inventories', [
            'id' => $resource->id,
        ]);
    }
}
