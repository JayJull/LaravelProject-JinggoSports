<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengembalianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengembalians')->insert([
            [
                'deskripsi' => 'Pengembalian alat dalam kondisi baik.',
                'tggl_kembali' => '2024-10-07',
                'bukti' => null,
                'petugas_id' => 1,
                'id_peminjaman' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],            
        ]);
    }
}