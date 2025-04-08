<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Konseling;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonselingController extends Controller
{
    // Admin ==========================================================================
    public function adminIndex()
    {
        $title = 'Konseling';
        $konseling = Konseling::with('siswa', 'status', 'jawaban')->get();

        return view('dashboard.konseling.index', compact('title', 'konseling'));
    }

    public function adminReply(Request $request)
    {
        $user = Auth::user();
        $guruID = $user->userable_type === 'App\Models\Guru' ? $user->userable->id : null;
        $getKonselingID = Konseling::find($request->konseling_id);

        $request->validate([
            'isi_jawaban' => 'required',
        ]);

        $insertJawaban = [
            'konseling_id' => $request->konseling_id,
            'isi_jawaban' => $request->isi_jawaban,
            'guru_id' => $guruID,
        ];

        if ($getKonselingID) {
            Jawaban::create($insertJawaban);
            Konseling::where('id', $request->konseling_id)->update([
                'status_id' => 2,
            ]);
            return redirect()->route('admin.konseling')->with('success', 'Konseling berhasil dibalas');
        } else {
            return redirect()->route('admin.konseling')->with('error', 'Konseling tidak ditemukan');
        }
    }

    public function siswaDetail($id)
    {
        $title = 'Detail Konseling';
        $siswa = Siswa::find($id);

        if (!$siswa) {
            abort(404, "Siswa tidak ditemukan");
        }

        $konseling = Konseling::where('siswa_id', $id)->with('status', 'jawaban')->get();

        return view('dashboard.konseling.siswa_detail', compact('title', 'siswa', 'konseling'));
    }
}
