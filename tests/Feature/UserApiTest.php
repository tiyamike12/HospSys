<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post('/api/users', [
            'name' => 'Samson Mpangowalimba',
            'email' => 'samson@gmail.com',
            'password' => bcrypt('Password'),
            'role_id' => 1,
            'phone_number' => '0991663323'
        ]);

        $response->assertStatus(201);
//        $response->assertJson([
//            'user' => $user,
//        ]);
    }

    public function test_can_get_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $user = User::factory()->create([
//            'name' => 'Test Resource',
//            'description' => 'This is a test resource.',
        ]);

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/users/' . $user->id);

        $response->assertStatus(200);
//        $response->assertJson([
//            'name' => 'Test Resource',
//            'description' => 'This is a test resource.',
//        ]);
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $resource = User::factory()->create([
//            'name' => 'Test Resource',
//            'description' => 'This is a test resource.',
        ]);

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put('/api/users/' . $resource->id, [
            'name' => 'Updated Test Resource',
            'email' => 'tiyamike@gmail.com',
            'role_id' => 1
        ]);

        $response->assertStatus(200);
//        $response->assertJson([
//            'name' => 'Updated Test Resource',
//            'description' => 'This is an updated test resource.',
//        ]);
    }

    public function test_can_delete_a_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $user = User::factory()->create([
//            'name' => 'Test Resource',
//            'description' => 'This is a test resource.',
        ]);

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete('/api/users/' . $user->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

}
