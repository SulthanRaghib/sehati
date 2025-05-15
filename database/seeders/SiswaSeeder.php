<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswas = [];
        for ($i = 1; $i <= 20; $i++) {
            $siswas[] = [
                'nisn' => '12345678' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'nama' => 'Siswa ' . $i,
                'jenis_kelamin' => $i % 2 === 0 ? 'L' : 'P',
                'kelas_id' => rand(1, 3),
            ];
        }

        DB::table('siswas')->insert($siswas);
    }
}
