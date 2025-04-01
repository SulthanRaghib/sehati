<?php

namespace Database\Seeders;

use App\Models\Jawaban;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JawabanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jawaban::create([
            'konseling_id' => 1,
            'guru_id' => 1,
            'isi_jawaban' => 'Saya sarankan untuk belajar lebih teratur dan tidak panik saat ujian.',
            'tanggal_jawaban' => now(),
        ]);
    }
}
