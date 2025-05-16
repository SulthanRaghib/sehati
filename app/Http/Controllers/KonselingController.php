<?php

namespace App\Http\Controllers;

use App\Events\NewKonseling;
use App\Exports\KonselingExport;
use App\Models\Jawaban;
use App\Models\KategoriKonseling;
use App\Models\Kelas;
use App\Models\Konseling;
use App\Models\Notifikasi;
use App\Models\Siswa;
use App\Models\Status;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class KonselingController extends Controller
{
    // Admin ==========================================================================
    public function adminIndex(Request $request)
    {
        $title = 'Konseling';
        $konseling = Konseling::with('siswa', 'status', 'jawaban', 'kategoriKonseling')
            ->when($request->today, function ($query) use ($request) {
                if ($request->today == '1') {
                    $query->whereDate('tanggal_konseling', Carbon::today());
                } elseif ($request->today == '7') {
                    $query->whereDate('tanggal_konseling', '>=', Carbon::now()->subDays(7));
                }
            })
            ->when($request->filled('bulan'), function ($query) use ($request) {
                $query->whereMonth('tanggal_konseling', $request->bulan);
            })
            ->when($request->filled('tahun'), function ($query) use ($request) {
                $query->whereYear('tanggal_konseling', $request->tahun);
            })
            ->when($request->filled('kelas'), function ($query) use ($request) {
                $query->whereHas('siswa', function ($q) use ($request) {
                    $q->where('kelas_id', $request->kelas);
                });
            })
            ->when($request->filled('kategori'), function ($query) use ($request) {
                $query->where('kategori_konseling_id', $request->kategori);
            })
            ->orderByRaw('
            CASE
                WHEN EXISTS (SELECT 1 FROM jawabans WHERE jawabans.konseling_id = konselings.id) THEN 1
                ELSE 0
            END ASC
        ')
            ->orderBy('tanggal_konseling', 'desc')
            ->get();

        $kelasList = Kelas::all();
        $kategoriList = KategoriKonseling::all();

        return view('dashboard.konseling.index', compact('title', 'konseling', 'kelasList', 'kategoriList'));
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
        $request->validate(
            [
                'judul' => 'required',
                'isi_konseling' => 'required',
            ],
            [
                'judul.required' => 'Judul konseling tidak boleh kosong.',
                'isi_konseling.required' => 'Isi konseling tidak boleh kosong.',
            ]
        );

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
        ], [
            'isi_jawaban.required' => 'Isi jawaban tidak boleh kosong.',
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

    public function downloadPdf(Request $request)
    {
        $konseling = Konseling::with(['siswa', 'kategoriKonseling', 'jawaban', 'jawaban.ratings'])
            ->when($request->today, function ($q) use ($request) {
                if ($request->today == '1') {
                    $q->whereDate('tanggal_konseling', today());
                } elseif ($request->today == '7') {
                    $q->whereDate('tanggal_konseling', '>=', Carbon::now()->subDays(7));
                }
            })
            ->when($request->bulan, fn($q) => $q->whereMonth('tanggal_konseling', (int) $request->bulan))
            ->when($request->tahun, fn($q) => $q->whereYear('tanggal_konseling', (int) $request->tahun))
            ->when($request->kelas, fn($q) => $q->whereHas('siswa', fn($q) => $q->where('kelas_id', $request->kelas)))
            ->when($request->kategori, fn($q) => $q->where('kategori_konseling_id', $request->kategori))
            ->get();

        if ($konseling->isEmpty()) {
            return redirect()->back()->with('no-data', 'Data tidak ditemukan berdasarkan filter yang dipilih.');
        }

        $kelasName = null;
        $kategoriName = null;
        $bulanName = null;
        $tahunName = null;

        if ($request->kelas) {
            $kelasModel = Kelas::find($request->kelas);
            $kelasName = $kelasModel ? "{$kelasModel->tingkat}" : null;
        }

        if ($request->kategori) {
            $kategoriModel = KategoriKonseling::find($request->kategori);
            $kategoriName = $kategoriModel ? Str::slug($kategoriModel->nama_kategori) : null;
        }

        if ($request->bulan) {
            $bulanName = Carbon::create(null, (int) $request->bulan, 1)->translatedFormat('F');
        }

        if ($request->tahun) {
            $tahunName = $request->tahun;
        }

        $tahun = $request->tahun ?? null;

        $timestamp = now()->format('Ymd_His');
        $filename = "{$timestamp}_konseling";

        if ($request->today == '1') {
            $filename .= '_hari-ini';
        } elseif ($request->today == '7') {
            $filename .= '_7-hari-terakhir';
        }

        if ($bulanName) {
            $filename .= "_bulan-{$bulanName}";
        }

        if ($tahunName) {
            $filename .= "_tahun-{$tahunName}";
        }

        if ($kelasName) {
            $filename .= "_kelas-{$kelasName}";
        }

        if ($kategoriName) {
            $filename .= "_kategori-{$kategoriName}";
        }

        $filename .= ".pdf";

        $pdf = Pdf::loadView('dashboard.konseling.exports.konseling_pdf', compact('konseling', 'request', 'tahun'))
            ->setPaper('A4', 'landscape');

        return $pdf->download($filename);
    }


    public function downloadExcel(Request $request)
    {
        $konseling = Konseling::with(['siswa', 'kategoriKonseling', 'jawaban', 'jawaban.ratings'])
            ->when($request->today, function ($q) use ($request) {
                if ($request->today == '1') {
                    $q->whereDate('tanggal_konseling', today());
                } elseif ($request->today == '7') {
                    $q->whereDate('tanggal_konseling', '>=', Carbon::now()->subDays(7));
                }
            })
            ->when($request->bulan, fn($q) => $q->whereMonth('tanggal_konseling', (int) $request->bulan))
            ->when($request->tahun, fn($q) => $q->whereYear('tanggal_konseling', (int) $request->tahun))
            ->when($request->kelas, fn($q) => $q->whereHas('siswa', fn($q) => $q->where('kelas_id', $request->kelas)))
            ->when($request->kategori, fn($q) => $q->where('kategori_konseling_id', $request->kategori))
            ->get();

        if ($konseling->isEmpty()) {
            return redirect()->back()->with('no-data', 'Data tidak ditemukan berdasarkan filter yang dipilih.');
        }

        $kelasName = null;
        $kategoriName = null;
        $bulanName = null;
        $tahunName = null;

        $bulanIndo = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        if ($request->kelas) {
            $kelasModel = Kelas::find($request->kelas);
            $kelasName = $kelasModel ? "{$kelasModel->tingkat}" : null;
        }

        if ($request->kategori) {
            $kategoriModel = KategoriKonseling::find($request->kategori);
            $kategoriName = $kategoriModel ? Str::slug($kategoriModel->nama_kategori) : null;
        }

        if ($request->bulan !== null && $request->bulan !== '') {
            $bulan = (int) $request->bulan;
            if ($bulan >= 1 && $bulan <= 12) {
                $bulanName = $bulanIndo[$bulan];
            }
        }

        if ($request->tahun !== null && $request->tahun !== '') {
            $tahunName = (int) $request->tahun;
        }

        $timestamp = now()->format('Ymd_His');
        $filename = "{$timestamp}_konseling";

        if ($request->today == '1') {
            $filename .= '_hari-ini';
        } elseif ($request->today == '7') {
            $filename .= '_7-hari-terakhir';
        }

        if ($bulanName) {
            $filename .= "_bulan-{$bulanName}";
        }

        if ($tahunName) {
            $filename .= "_tahun-{$tahunName}";
        }

        if ($kelasName) {
            $filename .= "_kelas-{$kelasName}";
        }

        if ($kategoriName) {
            $filename .= "_kategori-{$kategoriName}";
        }

        $filename .= ".xlsx";

        return Excel::download(new KonselingExport($request->all()), $filename);
    }


    // Siswa ==========================================================================
    public function siswaKonseling()
    {
        $title = 'Konseling';
        $user = Auth::user();
        $siswa = $user->userable;
        $konseling = $siswa->konseling()->with('status')->latest()->get();
        $kategoriKonseling = KategoriKonseling::all();

        return view('frontend.konseling.index', compact('title', 'konseling', 'siswa', 'user', 'kategoriKonseling'));
    }

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
            'kategori_konseling_id' => $request->kategori_konseling,
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
            ->with('status', 'jawaban', 'jawaban.ratings', 'kategoriKonseling')
            ->orderBy('tanggal_konseling', 'desc')
            ->get();
        $kategoriKonseling = KategoriKonseling::all();

        // dd($konseling);
        return view('frontend.konseling.riwayat', compact('title', 'konseling', 'kategoriKonseling'));
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
            'kategori_konseling_id' => $request->kategori_konseling,
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
