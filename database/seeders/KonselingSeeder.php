<?php

namespace Database\Seeders;

use App\Models\Konseling;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KonselingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Konseling::create([
            'siswa_id' => 1,
            'status_id' => 1,
            'kategori_konseling_id' => 1,
            'judul' => 'Konseling Akademik',
            'isi_konseling' => 'Saya merasa cemas dan tidak percaya diri saat ujian.',
            'tanggal_konseling' => now(),
        ]);
    }
}
