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
            ->orderByRaw('
                CASE
                    WHEN EXISTS (SELECT 1 FROM jawabans WHERE jawabans.konseling_id = konselings.id) THEN 1
                    ELSE 0
                END ASC
            ') // Belum dibalas (0) dulu, yang sudah dibalas (1) belakangan
            ->orderBy('tanggal_konseling', 'desc')
            ->get();

        return view('dashboard.konseling.index', compact('title', 'konseling'));
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

    public function adminEdit($id)
    {
        $title = 'Edit Jawaban Konseling';
        $jawaban = Jawaban::where('konseling_id', $id)->first();

        if (!$jawaban) {
            abort(404, "Jawaban tidak ditemukan");
        }

        return view('dashboard.konseling.edit', compact('title', 'jawaban'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'isi_jawaban' => 'required',
        ]);

        $jawaban = Jawaban::where('konseling_id', $id)->first();

        if (!$jawaban) {
            abort(404, "Jawaban tidak ditemukan");
        }

        $jawaban->update([
            'isi_jawaban' => $request->isi_jawaban,
            'tanggal_jawaban' => now(),
        ]);

        return redirect()->route('admin.konseling')->with('success', 'Jawaban berhasil diperbarui');
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

    // Siswa ==========================================================================

    public function siswaKonselingStore(Request $request)
    {
        $request->validate(
            [
                'judul' => 'required|string|max:255',
                'isi_konseling' => 'required|string',
                'kategori_konseling' => 'required',
            ],
            [
                'judul.required' => 'Yuk, tulis dulu kalimat singkat tentang apa yang kamu rasakan.',
                'isi_konseling.required' => 'Bagikan ceritamu lebih lengkap, kami siap mendengarkan sepenuh hati.',
                'kategori_konseling.required' => 'Pilih topik yang paling menggambarkan isi hatimu, ya.',
            ]
        );

        $konseling = Konseling::create([
            'judul' => $request->judul,
            'isi_konseling' => $request->isi_konseling,
            'kategori_konseling' => $request->kategori_konseling,
            'siswa_id' => Auth::user()->userable->id,
            'status_id' => 1,
            'tanggal_konseling' => now(),
        ]);

        $notifikasi = Notifikasi::create([
            'user_id' => Auth::user()->userable->id,
            'title' => 'Konseling Baru',
            'type' => 'konseling',
            'body' => $request->judul,
            'related_id' => $konseling->id,
            'related_type' => Konseling::class,
        ]);

        event(new NewKonseling($notifikasi));

        return redirect()->back()->with('success', 'Konseling berhasil dikirim!');
    }

    public function siswaKonselingRiwayat()
    {
        $title = 'Riwayat Konseling';
        $konseling = Konseling::where('siswa_id', Auth::user()->userable->id)
            ->with('status', 'jawaban', 'jawaban.ratings')
            ->orderBy('tanggal_konseling', 'desc')
            ->get();

        return view('frontend.konseling.riwayat', compact('title', 'konseling'));
    }

    public function siswaUpdateKonseling(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_konseling' => 'required|string',
            'kategori_konseling' => 'required',
        ], [
            'judul.required' => 'Yuk, tulis dulu kalimat singkat tentang apa yang kamu rasakan.',
            'isi_konseling.required' => 'Bagikan ceritamu lebih lengkap, kami siap mendengarkan sepenuh hati.',
            'kategori_konseling.required' => 'Pilih topik yang paling menggambarkan isi hatimu, ya.',
        ]);

        $konseling = Konseling::find($id);

        if (!$konseling) {
            abort(404, "Konseling tidak ditemukan");
        }

        $konseling->update([
            'judul' => $request->judul,
            'isi_konseling' => $request->isi_konseling,
            'kategori_konseling' => $request->kategori_konseling,
            'tanggal_konseling' => now(),
        ]);

        return redirect()->back()->with('success', 'Konseling berhasil diperbarui');
    }

    public function siswaKonselingDestroy($id)
    {
        $konseling = Konseling::find($id);

        if ($konseling) {
            $konseling->delete();
            return redirect()->back()->with('success', 'Konseling berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Konseling tidak ditemukan');
        }
    }
}
