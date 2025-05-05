<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Konseling;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Homepage | Siswa';
        $user = Auth::user();
        $artikelCount = Artikel::count();
        $konselingCount = Konseling::count();
        $guruBKCount = User::where('role', 'gurubk')->count();
        $siswaTerbantu = Siswa::whereHas('konseling', function ($konselingQuery) {
            $konselingQuery->where('status_id', 3) // status selesai
                ->whereHas('jawaban.ratings', function ($ratingQuery) {
                    $ratingQuery->where('rating', '>=', 4);
                });
        })->count();

        // Default nilai
        $siswa = null;

        // Cek apakah user sudah login
        if (Auth::check()) {
            // Baru akses jika user tidak null
            $siswa = $user->userable_type === 'App\Models\Siswa' ? $user->userable : null;
        }

        return view('frontend.index', compact('title', 'user', 'siswa', 'artikelCount', 'konselingCount', 'guruBKCount', 'siswaTerbantu'));
    }

    public function artikelSiswa()
    {
        $title = 'Artikel';
        $artikel = Artikel::with('artikelKategori', 'user')->where('status', 'publish')->latest()->get();
        $user = Auth::user();

        // Default nilai
        $siswa = null;

        // Cek apakah user sudah login
        if (Auth::check()) {
            // Baru akses jika user tidak null
            $siswa = $user->userable_type === 'App\Models\Siswa' ? $user->userable : null;
        }

        return view('frontend.artikel.index', compact('title', 'artikel', 'siswa', 'user'));
    }

    public function siswaKonseling()
    {
        $title = 'Konseling';
        $user = Auth::user();
        $siswa = $user->userable;
        $konseling = $siswa->konseling()->with('status')->latest()->get();

        return view('frontend.konseling.index', compact('title', 'konseling', 'siswa', 'user'));
    }
}
