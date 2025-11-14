<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase; 

    public function test_a_user_can_be_created()
    {
        $admin = User::factory()->create();

        // 2. Data user baru
        $data = [
            'name' => 'Nurul Atha',
            'email' => 'nurul@example.com',
            'password' => bcrypt('password123'), 
        ];

        $response = $this->actingAs($admin)->post(route('users.store'), $data);

        $this->assertDatabaseHas('users', [
            'email' => 'nurul@example.com',
            'name' => 'Nurul Atha',
        ]);

        $response->assertRedirect(route('users.index'));
    }
}