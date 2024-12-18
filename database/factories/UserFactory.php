<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Anggota;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $anggota = Anggota::factory()->create(); // Membuat anggota terlebih dahulu
        return [
            'id_anggota' => $anggota->id_anggota, // Menyimpan id_anggota dari anggota yang baru dibuat
            'gambar' => null, 
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Default password
            'current_role_id' => null, // Sesuaikan jika menggunakan role
            'token' => Str::random(10),
        ];
    }
}

