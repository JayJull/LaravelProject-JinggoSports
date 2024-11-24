<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Divisi;
use Illuminate\Database\Seeder;

class DivisiHasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua anggota yang diterima
        $anggotaDiterima = Anggota::where('status', 'diterima')->get();

        foreach ($anggotaDiterima as $anggota) {
            // Tentukan divisi-divisi yang akan dimasukkan (misalnya, divisi pertama dan kedua)
            $divisis = Divisi::take(2)->get(); // Ambil dua divisi pertama, bisa disesuaikan

            foreach ($divisis as $divisi) {
                // Masukkan anggota ke dalam setiap divisi yang diambil
                $divisi->anggota()->attach($anggota->id_anggota);
            }
        }
    }
}
