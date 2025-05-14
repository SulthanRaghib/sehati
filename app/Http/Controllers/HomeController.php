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

    public function artikelSiswa(Request $request)
    {
        $title = 'Artikel';
        $perPage = $request->get('perPage', 6);
        $search = $request->get('search');

        $query = Artikel::with('artikelKategori', 'user')
            ->where('status', 'publish');

        // Jika ada input pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('isi', 'like', '%' . $search . '%')
                    ->orWhereHas('artikelKategori', function ($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%');
                    });
            });
        }

        $artikel = $query->latest()->paginate($perPage)
            ->appends([
                'perPage' => $perPage,
                'search' => $search,
            ]);

        $user = Auth::user();
        $siswa = null;

        if (Auth::check()) {
            $siswa = $user->userable_type === 'App\Models\Siswa' ? $user->userable : null;
        }

        return view('frontend.artikel.index', compact('title', 'artikel', 'siswa', 'user'));
    }
}
