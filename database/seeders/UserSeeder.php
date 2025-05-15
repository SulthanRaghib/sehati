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
        $guruBk = Guru::where('nama', 'Sari Hartini')->first();
        $admin = Guru::where('nama', 'Taupik')->first();
        $developer = Guru::where('nama', 'Developer')->first();
        $siswa = Siswa::all();

        // User untuk Guru BK
        User::create([
            'name' => $guruBk->nama,
            'email' => 'gurubk@gmail.com',
            'password' => Hash::make('guru#123'),
            'role' => 'gurubk',
            'added_by_role' => 'admin',
            'userable_id' => $guruBk->id,
            'userable_type' => Guru::class,
            'remember_token' => Str::random(60),
        ]);

        // User untuk Siswa
        foreach ($siswa as $index => $s) {
            User::create([
                'name' => $s->nama,
                'email' => 'siswa' . ($index + 1) . '@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'siswa',
                'added_by_role' => 'gurubk',
                'userable_id' => $s->id,
                'userable_type' => Siswa::class,
                'remember_token' => Str::random(60),
            ]);
        }

        // User untuk Kepala Sekolah (Admin)
        User::create([
            'name' => $admin->nama,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin#123'),
            'role' => 'admin', // Admin tetap bagian dari guru
            'added_by_role' => 'admin',
            'userable_id' => $admin->id,
            'userable_type' => Guru::class,
            'remember_token' => Str::random(60),
        ]);

        // User untuk Developer
        User::create([
            'name' => $developer->nama,
            'email' => 'developer@gmail.com',
            'password' => Hash::make('developer#123'),
            'role' => 'developer',
            'added_by_role' => 'admin',
            'userable_id' => $developer->id,
            'userable_type' => Guru::class,
            'remember_token' => Str::random(60),
        ]);
    }
}
