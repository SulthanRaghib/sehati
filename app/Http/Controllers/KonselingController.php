<?php

namespace App\Http\Controllers;

use App\Events\NewKonseling;
use App\Models\Jawaban;
use App\Models\Konseling;
use App\Models\Notifikasi;
use App\Models\Siswa;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonselingController extends Controller
{
    // Admin ==========================================================================
    public function adminIndex()
    {
        $title = 'Konseling';
        $konseling = Konseling::with('siswa', 'status', 'jawaban')
            ->orderBy('tanggal_konseling', 'desc')
            ->get();

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

    public function adminCreate()
    {
        $title = 'Buat Konseling';
        $siswa = Siswa::all();

        return view('dashboard.konseling.create', compact('title', 'siswa'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi_konseling' => 'required',
        ]);

        // $jumlahInbox = 1;
        // event(new NewKonseling([
        //     'judul' => $request->judul,
        //     'isi_konseling' => $request->isi_konseling,
        //     'siswa_id' => 1,
        //     'status_id' => 1,
        //     'tanggal_konseling' => now(),
        //     'jumlah_inbox' => $jumlahInbox,
        // ]));

        Konseling::create([
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

        return redirect()->back()->with('success', 'Konseling berhasil dibuat');
    }

    public function adminDestroy($id)
    {
        $konseling = Konseling::find($id);

        if ($konseling) {
            $konseling->delete();
            return redirect()->route('admin.konseling')->with('success', 'Konseling berhasil dihapus');
        } else {
            return redirect()->route('admin.konseling')->with('error', 'Konseling tidak ditemukan');
        }
    }
}
