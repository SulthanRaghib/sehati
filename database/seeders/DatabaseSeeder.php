<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AgamaSeeder::class,
            StatusSeeder::class,
            KelasSeeder::class,
            PekerjaanSeeder::class,
            PendidikanTerakhirSeeder::class,
            GuruSeeder::class,
            SiswaSeeder::class,
            UserSeeder::class,
            RatingSeeder::class,
            ArtikelKategoriSeeder::class,
            ArtikelSeeder::class,
        ]);
    }
}
