<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtikelKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('artikel_kategoris')->insert([
            [
                'nama' => 'Konseling',
                'slug' => 'konseling',
            ],
            [
                'nama' => 'Motivasi',
                'slug' => 'motivasi',
            ],
            [
                'nama' => 'Psikologi',
                'slug' => 'psikologi',
            ]
        ]);
    }
}
