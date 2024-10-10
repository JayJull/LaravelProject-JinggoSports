<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'nim' => '362258302111',
                'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
                'gambar' => null,
                'email' => 'adminukm@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pengurus',
                'nim' => '362258302112',
                'prodi' => 'Manajemen Bisnis Pariwisata',
                'gambar' => null,
                'email' => 'pengurusukm@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('pengurus'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],            
        ]);
    }
}
