<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriKonselingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_konselings')->insert([
            [
                'nama_kategori' => 'Akademik',
                'contoh_kategori' => 'Tugas, Ujian, Nilai, Pelajaran',
            ],
            [
                'nama_kategori' => 'Non Akademik',
                'contoh_kategori' => 'Organisasi, Kegiatan, Minat',
            ],
            [
                'nama_kategori' => 'Keluarga',
                'contoh_kategori' => 'Hubungan dengan Orang Tua, Saudara',
            ],
            [
                'nama_kategori' => 'Pertemanan',
                'contoh_kategori' => 'Konflik, Merasa Dijauhi, Teman Dekat',
            ],
            [
                'nama_kategori' => 'Sosial',
                'contoh_kategori' => 'Kegiatan, Organisasi, Komunitas',
            ],
            [
                'nama_kategori' => 'Karir',
                'contoh_kategori' => 'Pekerjaan, Cita-cita, Rencana Masa Depan',
            ],
        ]);
    }
}
