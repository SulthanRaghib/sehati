<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendidikanTerakhirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pendidikan_terakhirs')->insert([
            ['nama' => 'Tidak Sekolah'],
            ['nama' => 'SD'],
            ['nama' => 'SMP'],
            ['nama' => 'SMA'],
            ['nama' => 'D1'],
            ['nama' => 'D2'],
            ['nama' => 'D3'],
            ['nama' => 'D4'],
            ['nama' => 'S1'],
            ['nama' => 'S2'],
            ['nama' => 'S3'],
        ]);
    }
}
