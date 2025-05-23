<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Rating;
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
            KategoriKonselingSeeder::class,
            GuruSeeder::class,
            SiswaSeeder::class,
            UserSeeder::class,
           // KonselingSeeder::class,
           // JawabanSeeder::class,
           // RatingSeeder::class,
            ArtikelKategoriSeeder::class,
            ArtikelSeeder::class,
        ]);
    }
}
