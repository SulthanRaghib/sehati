<?php

namespace Database\Seeders;

use App\Models\Konseling;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating;
use Faker\Factory as Faker;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $konselings = Konseling::where('status_id', 3)->with('jawaban')->get();

        foreach ($konselings as $konseling) {
            // Pastikan ada jawaban untuk konseling ini
            if ($konseling->jawaban) {
                Rating::create([
                    'jawaban_id' => $konseling->jawaban->id,
                    'siswa_id' => $konseling->siswa_id,
                    'rating' => rand(1, 5),
                    'komentar' => rand(0, 1) ? $faker->sentence() : null,
                ]);
            }
        }
    }
}
