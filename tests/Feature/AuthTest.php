<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test for successful login
     *
     * @return void
     */
    public function test_can_login(): void
    {
        $this->withExceptionHandling();
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
//            ->assertJson([
//                'message' => 'Login successful.',
//            ])
            ->assertJsonStructure([
                'user',
                'token',
            ]);
    }

}
