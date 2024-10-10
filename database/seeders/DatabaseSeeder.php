<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProdiSeeder::class,            
            AnggotaSeeder::class,
            AlatSeeder::class,
            PresensiSeeder::class,
            PeminjamanSeeder::class,
            PengembalianSeeder::class,
            DivisiSeeder::class,
            JadwalSeeder::class,
            JabatanSeeder::class,
            TimeLineSeeder::class,
            DivisiHasSeeder::class,
            JabatanHasSeeder::class,           
        ]);
    }
}
