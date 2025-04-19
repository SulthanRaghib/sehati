<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use Illuminate\Http\Request;
use App\Events\NewKonseling;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Log;

class ApiKonselingController extends Controller
{
    public function index()
    {
        $konseling = Konseling::all();
        return response()->json($konseling);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_konseling' => 'required|string',
        ]);

        $konseling = Konseling::create([
            'judul' => $request->judul,
            'isi_konseling' => $request->isi_konseling,
            'siswa_id' => 1,
            'status_id' => 1,
            'tanggal_konseling' => now(),
        ]);

        $notifikasi = Notifikasi::create([
            'user_id' => 1,
            'title' => 'Konseling Baru',
            'body' => $request->judul,
        ]);

        event(new NewKonseling($notifikasi));



        return response()->json([
            'message' => 'Konseling created successfully',
            'data' => $konseling,
        ], 201);
    }
}
