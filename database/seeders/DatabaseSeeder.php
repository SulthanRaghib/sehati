<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Pekerjaan;
use App\Models\PendidikanTerakhir;
use App\Models\Siswa;
use App\Models\User;
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
            KonselingSeeder::class,
            JawabanSeeder::class,
            RatingSeeder::class,
        ]);
    }
}
