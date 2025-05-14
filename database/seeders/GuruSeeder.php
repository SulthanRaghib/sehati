<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gurus')->insert([
            // Guru BK
            [
                'nip' => '1234567890',
                'nama' => 'Ida Ayu Putu',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'alamat' => 'Jl. Kebayoran Lama No. 1',
                'agama_id' => 1,
                'pendidikan_terakhir_id' => 9,
            ],
            // Admin
            [
                'nip' => '0110221007',
                'nama' => 'Developer',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Cilegon',
                'tanggal_lahir' => '1990-01-01',
                'alamat' => 'Jl. Kebayoran Lama No. 1',
                'agama_id' => 1,
                'pendidikan_terakhir_id' => 9,
            ],
        ]);
    }
}
