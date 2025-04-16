<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('artikels')->insert([
            [
                'judul' => 'Pentingnya Bimbingan Konseling dalam Pendidikan',
                'slug' => Str::slug('Pentingnya Bimbingan Konseling dalam Pendidikan'),
                'isi' => 'Bimbingan dan konseling (BK) memegang peran krusial dalam sistem pendidikan, berfungsi sebagai sarana pendukung bagi siswa dalam menghadapi berbagai tantangan akademik, emosional, dan sosial. Layanan ini bertujuan untuk membantu siswa mengoptimalkan potensi diri dan mencapai kesejahteraan secara menyeluruh. <br><br><h2>Pentingnya Bimbingan dan Konseling di Era Modern</h2><p>Di era digital dan globalisasi saat ini, siswa menghadapi tantangan yang lebih kompleks, termasuk tekanan dari media sosial dan perkembangan teknologi yang pesat. Konselor sekolah berperan penting dalam membantu siswa mengatasi tekanan akademik dan masalah kesehatan mental seperti kecemasan dan depresi. </p>',
                'gambar' => 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhE5wJcxyqqba8044FIQTUnW_bzd7qYrEY4Ov8I6Zj8XJuAxk7OyiYSzxwK7uBVWsPUHtivYOnHj2Bi0v6X84FRZ0ekCvqydyVRNnKX2PK874GB_2k9k59cWEVLEUms68hQtf6mjiZ4RXXO/s640/counseling_0.jpg',
                'artikel_kategori_id' => 1,
                'user_id' => 1,
                'sumber' => 'https://psychology.binus.ac.id/2023/11/06/peran-penting-guru-bimbingan-konseling-bk-dalam-pengembangan-siswa/',
                'tanggal_terbit' => now(),
                'status' => 'draft',
                'views' => 0
            ]
        ]);
    }
}
