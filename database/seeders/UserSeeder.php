<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'name' => $guruBk->nama,
            'email' => 'gurubk@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'gurubk',
            'added_by_role' => 'admin',
            'userable_id' => $guruBk->id,
            'userable_type' => Guru::class,
            'remember_token' => Str::random(60),
        ]);

        // User untuk Siswa
        User::create([
            'name' => $siswa->nama,
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'siswa',
            'added_by_role' => 'gurubk',
            'userable_id' => $siswa->id,
            'userable_type' => Siswa::class,
            'remember_token' => Str::random(60),
        ]);

        // User untuk Kepala Sekolah (Admin)
        User::create([
            'name' => $kepalaSekolah->nama,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin#123'),
            'role' => 'admin', // Admin tetap bagian dari guru
            'added_by_role' => 'admin',
            'userable_id' => $kepalaSekolah->id,
            'userable_type' => Guru::class,
            'remember_token' => Str::random(60),
        ]);
    }
}
