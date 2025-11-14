<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Kategori;

class KategoriTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $data = [
            'nama_kategori' => 'Minuman',
        ];
        $response = $this->post(route('admin.kategori.store'), $data);

        $this->assertDatabaseHas('kategoris', [
            'nama_kategori' => 'Minuman',
        ]);
        $response->assertRedirect(route('admin.kategori.index'));

    }
}
