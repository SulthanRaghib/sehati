<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guruBk = Guru::where('nama', 'Ida Ayu Putu')->first();
        $kepalaSekolah = Guru::where('nama', 'Joko')->first();
        $siswa = Siswa::where('nama', 'Syamil')->first();

        // User untuk Guru BK
        User::create([
            'name' => 'Guru BK',
            'email' => 'gurubk@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'gurubk',
            'userable_id' => $guruBk->id,
            'userable_type' => Guru::class,
        ]);

        // User untuk Siswa
        User::create([
            'name' => 'Siswa',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'siswa',
            'userable_id' => $siswa->id,
            'userable_type' => Siswa::class,
        ]);

        // User untuk Kepala Sekolah (Admin)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin', // Admin tetap bagian dari guru
            'userable_id' => $kepalaSekolah->id,
            'userable_type' => Guru::class,
        ]);
    }
}
