<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pekerjaans')->insert([
            ['nama' => 'Pelajar'],
            ['nama' => 'Mahasiswa'],
            ['nama' => 'Pegawai Negeri Sipil'],
            ['nama' => 'TNI/Polri'],
            ['nama' => 'Pegawai Swasta'],
            ['nama' => 'Wiraswasta'],
            ['nama' => 'Petani'],
            ['nama' => 'Nelayan'],
            ['nama' => 'Buruh'],
            ['nama' => 'Pensiunan'],
            ['nama' => 'Ibu Rumah Tangga'],
            ['nama' => 'Tidak Bekerja'],
        ]);
    }
}
