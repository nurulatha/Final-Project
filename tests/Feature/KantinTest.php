<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KantinTest extends TestCase

{
    use RefreshDatabase;

    public function test_a_user_can_add_a_kantin()
    {
        $user = User::factory()->create();
        $data = [
            'nama_kantin' => 'Kantin Sehat',
            'lokasi' => 'Gedung A',
            'user_id' => '2'
        ];
        $response = $this->actingAs($user)->post(route('kantin.store'), $data);
        $this->assertDatabaseHas('kantins', [
            'nama_kantin' => 'Kantin Sehat',
        ]);
        $response->assertRedirect(route('kantin.index'));
    }
}
