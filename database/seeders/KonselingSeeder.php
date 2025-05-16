<?php

namespace Database\Seeders;

use App\Models\Konseling;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KonselingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $statusId = rand(1, 3); // acak antara Menunggu, Dijawab, Selesai

            Konseling::create([
                'siswa_id' => rand(1, 8), // acak antara ID 1–8
                'status_id' => $statusId,
                'kategori_konseling_id' => rand(1, 7),
                'judul' => 'Konseling Dummy ' . $i,
                'isi_konseling' => 'Ini adalah isi konseling dummy ke-' . $i,
                'tanggal_konseling' => Carbon::now()->subDays(rand(0, 30)),
            ]);
        }
    }
}
