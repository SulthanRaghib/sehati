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
                'judul' => 'Menjaga Kesehatan Mental di Era Modern: Kebutuhan yang Sering Diabaikan',
                'slug' => Str::slug('Menjaga Kesehatan Mental di Era Modern: Kebutuhan yang Sering Diabaikan'),
                'isi' => 'Di tengah arus kehidupan yang semakin cepat dan kompleks, kesehatan mental menjadi aspek penting yang sering kali terabaikan. Padahal, kesehatan mental memengaruhi cara seseorang berpikir, merasa, bertindak, bahkan berinteraksi dengan orang lain. Tanpa kondisi mental yang stabil, berbagai aspek kehidupan—baik pekerjaan, pendidikan, maupun hubungan sosial—dapat terganggu.',
                'gambar' => 'https://source.unsplash.com/600x400/?education,counseling',
                'artikel_kategori_id' => 1,
                'user_id' => 1,
                'sumber' => 'https://psychology.binus.ac.id/',
                'tanggal_terbit' => now(),
                'status' => 'draft',
                'views' => 0,
            ],
            [
                'judul' => 'Mengenal Kesehatan Mental Remaja',
                'slug' => Str::slug('Mengenal Kesehatan Mental Remaja'),
                'isi' => 'Kesehatan mental merupakan aspek penting dalam tumbuh kembang remaja...',
                'gambar' => 'https://source.unsplash.com/600x400/?mental-health,teenager',
                'artikel_kategori_id' => 2,
                'user_id' => 1,
                'sumber' => 'https://kemenpppa.go.id/',
                'tanggal_terbit' => now(),
                'status' => 'publish',
                'views' => 3,
            ],
            [
                'judul' => 'Strategi Menghadapi Tekanan Akademik',
                'slug' => Str::slug('Strategi Menghadapi Tekanan Akademik'),
                'isi' => 'Tekanan akademik sering kali menjadi beban bagi siswa, terutama saat ujian...',
                'gambar' => 'https://source.unsplash.com/600x400/?stress,study',
                'artikel_kategori_id' => 1,
                'user_id' => 1,
                'sumber' => 'https://psikologi.ui.ac.id/',
                'tanggal_terbit' => now(),
                'status' => 'publish',
                'views' => 7,
            ],
            // Tambahkan 17 data dummy lainnya:
            ...collect(range(4, 20))->map(function ($i) {
                return [
                    'judul' => "Artikel Dummy Ke-$i",
                    'slug' => Str::slug("Artikel Dummy Ke-$i"),
                    'isi' => "Ini adalah isi dari artikel dummy ke-$i. Artikel ini hanya untuk keperluan testing seeder.",
                    'gambar' => "https://source.unsplash.com/600x400/?article,$i",
                    'artikel_kategori_id' => rand(1, 3),
                    'user_id' => 1,
                    'sumber' => "https://example.com/artikel-$i",
                    'tanggal_terbit' => now()->subDays(rand(0, 10)),
                    'status' => rand(0, 1) ? 'publish' : 'draft',
                    'views' => rand(0, 100),
                ];
            })->toArray(),
        ]);
    }
}
