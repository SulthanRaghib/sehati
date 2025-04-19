<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function fetchNotifikasi()
    {
        $notifs = Notifikasi::where('user_id', 1)->latest()->get();

        return response()->json($notifs);
    }

    public function tandaiDibaca($id)
    {
        $notif = Notifikasi::findOrFail($id);
        $notif->update(['is_read' => true]);

        return response()->json(['message' => 'Notifikasi ditandai dibaca']);
    }

    public function tandaiSudahDibaca(Request $request)
    {
        Notifikasi::where('is_read', false)->update(['is_read' => true]);
        return response()->json(['status' => 'success']);
    }
}
