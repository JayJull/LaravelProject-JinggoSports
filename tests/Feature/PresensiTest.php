<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PresensiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_lakukan_presensi_test(): void
    {
        $user = User::factory()->create([
            'nim' => '362258302063',
            'prodi' => 'TRPL',
            'id_anggota'=>4
        ]);
        $user->assignRole('pengurus');
        $response = $this->get('/presensi');
        $response->assertStatus(200);
    }
}
