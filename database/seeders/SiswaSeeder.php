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
        DB::table('siswas')->insert([
            [
                'nisn' => '1234567890',
                'nama' => 'Syamil',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2000-01-01',
                'jenis_kelamin' => 'L',
                'agama_id' => 1,
                'kelas_id' => 1,
                'alamat' => 'Jl. Kebayoran Lama No. 1',
                'nik_ayah' => '1234567890',
                'nama_ayah' => 'Joko',
                'tempat_lahir_ayah' => 'Jakarta',
                'tanggal_lahir_ayah' => '1990-01-01',
                'pekerjaan_ayah_id' => 1,
                'nik_ibu' => '1234567890',
                'nama_ibu' => 'Fatimah',
                'tempat_lahir_ibu' => 'Jakarta',
                'tanggal_lahir_ibu' => '1990-01-01',
                'pekerjaan_ibu_id' => 1,
            ]
        ]);
    }
}
