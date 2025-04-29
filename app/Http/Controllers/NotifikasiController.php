<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function fetchNotifikasiKonseling()
    {
        $notifs = Notifikasi::where('type', 'konseling')->latest()->get();

        return response()->json($notifs);
    }

    public function fetchNotifikasiJawaban()
    {
        $siswaID = Auth::user()->userable->id;
        $notifs = Notifikasi::where('user_id', $siswaID)
            ->where('type', 'jawaban')
            ->latest()
            ->get();

        return response()->json($notifs);
    }

    public function tandaiDibacaKonseling($id)
    {
        $notif = Notifikasi::findOrFail($id)->where('type', 'konseling')->first();
        $notif->update(['is_read' => true]);

        return response()->json(['message' => 'Notifikasi ditandai dibaca']);
    }

    public function tandaiSudahDibacaKonseling(Request $request)
    {
        Notifikasi::where('is_read', false)
            ->where('type', 'konseling')
            ->update(['is_read' => true]);
        return response()->json(['message' => 'Notifikasi konseling ditandai sudah dibaca']);
    }

    public function tandaiSudahDibacaJawaban(Request $request)
    {
        $siswaID = Auth::user()->userable->id;
        Notifikasi::where('is_read', false)
            ->where('user_id', $siswaID)
            ->where('type', 'jawaban')
            ->update(['is_read' => true]);
        return response()->json(['message' => 'Notifikasi jawaban ditandai sudah dibaca']);
    }
}
