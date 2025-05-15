<?php

namespace Database\Seeders;

use App\Models\Jawaban;
use App\Models\Konseling;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JawabanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $konselings = Konseling::where('status_id', '!=', 1)->get();

        foreach ($konselings as $konseling) {
            Jawaban::create([
                'konseling_id' => $konseling->id,
                'guru_id' => rand(1, 2), // pastikan guru_id 1-3 tersedia
                'isi_jawaban' => 'Jawaban untuk konseling id ' . $konseling->id,
                'tanggal_jawaban' => Carbon::parse($konseling->tanggal_konseling)->addDays(1),
            ]);
        }
    }
}
