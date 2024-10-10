<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('anggotas')->insert([
            [
                'nama' => 'Anggota',
                'nim' => '362910229301',
                'email' => 'testanggota@gmail.com',
                'semester' => '3',
                'no_telp' => '081234567890',
                'cv' => null,
                'status' => 'menunggu',
                'id_prodi' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],           
        ]);
    }
}
