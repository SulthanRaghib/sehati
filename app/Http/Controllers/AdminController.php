<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Konseling;
use App\Models\Pekerjaan;
use App\Models\PendidikanTerakhir;
use App\Models\Siswa;
use App\Models\TahunAkademik;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $title = 'Dashboard';
        $user = Auth::user();

        $guru = $user->userable_type == 'App\Models\Guru' ? $user->userable : null;

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Mulai query dasar
        $query = Konseling::query();

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }

        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        $konselings = $query->get();

        // Penentuan rentang hari hanya kalau ada filter bulan & tahun
        if ($bulan && $tahun) {
            $daysInMonth = Carbon::create($tahun, $bulan)->daysInMonth;
            $chartLabels = [];
            $chartData = [];

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $start = Carbon::create($tahun, $bulan, $day)->startOfDay();
                $end = Carbon::create($tahun, $bulan, $day)->endOfDay();

                $chartLabels[] = $day;
                $chartData[] = $konselings->whereBetween('created_at', [$start, $end])->count();
            }
        } elseif ($tahun && !$bulan) {
            // Filter per bulan dalam tahun
            $chartLabels = [];
            $chartData = [];

            for ($m = 1; $m <= 12; $m++) {
                $count = $konselings->filter(function ($item) use ($m) {
                    return $item->created_at->month == $m;
                })->count();

                $chartLabels[] = DateTime::createFromFormat('!m', $m)->format('F');
                $chartData[] = $count;
            }
        } elseif ($bulan && !$tahun) {
            // Filter per hari dalam bulan ini tahun ini
            $tahun = now()->year;
            $daysInMonth = Carbon::create($tahun, $bulan)->daysInMonth;

            $chartLabels = [];
            $chartData = [];

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $start = Carbon::create($tahun, $bulan, $day)->startOfDay();
                $end = Carbon::create($tahun, $bulan, $day)->endOfDay();

                $chartLabels[] = $day;
                $chartData[] = $konselings->whereBetween('created_at', [$start, $end])->count();
            }
        } else {
            // Default sekarang: bulan & tahun saat ini
            $bulan = now()->month;
            $tahun = now()->year;
            $daysInMonth = Carbon::create($tahun, $bulan)->daysInMonth;

            $chartLabels = [];
            $chartData = [];

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $start = Carbon::create($tahun, $bulan, $day)->startOfDay();
                $end = Carbon::create($tahun, $bulan, $day)->endOfDay();

                $chartLabels[] = $day;
                $chartData[] = Konseling::whereBetween('created_at', [$start, $end])->count();
            }
        }

        // TOPIK POPULER
        $keywords = [];
        $judulList = Konseling::pluck('judul')->toArray();


        foreach ($judulList as $judul) {
            $judul = strtolower($judul);
            $judul = preg_replace('/[^a-z0-9\s]/', '', $judul); // hilangkan tanda baca
            $words = explode(' ', $judul);

            foreach ($words as $word) {
                if (strlen($word) > 3 && !in_array($word, ['yang', 'dari', 'dan', 'untuk', 'pada'])) {
                    $keywords[$word] = ($keywords[$word] ?? 0) + 1;
                }
            }
        }

        // Ambil 5 teratas
        arsort($keywords);
        $topikPopuler = array_slice($keywords, 0, 4, true);

        // Ambil total data Guru BK, validasi dari user role gurubk
        $guruCount = User::where('role', 'gurubk')->count();

        // Ambil total data konseling
        $konselingCount = Konseling::count();

        // Ambil total siswa yang sudah melakukan konseling
        $siswaCount = Siswa::whereHas('konseling')->count();

        return view('dashboard.index', compact('title', 'user', 'guru', 'chartLabels', 'chartData', 'bulan', 'tahun', 'topikPopuler', 'guruCount', 'konselingCount', 'siswaCount'));
    }

    // USERS =================================================================================
    public function users()
    {
        $title = 'Data Pengguna';
        $u = Auth::user();

        if ($u->role === 'admin') {
            $user = User::all(); // Admin melihat semua user
        } elseif ($u->role === 'gurubk') {
            // Guru BK hanya melihat user yang dibuat oleh sesama Guru BK
            $user = User::where('added_by_role', 'gurubk')
                ->orWhere(function ($query) {
                    $query->where('added_by_role', 'admin')
                        ->where('userable_type', 'App\\Models\\Siswa'); // Pastikan hanya siswa
                })
                ->get();
        }

        return view('dashboard.admin.users.index', compact('title', 'user'));
    }

    public function createUser()
    {
        $title = 'Tambah Pengguna';
        $guru = Guru::all();
        $siswa = Siswa::all();

        return view('dashboard.admin.users.create', compact('title', 'guru', 'siswa'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => [
                'required',
                Rule::in(['admin', 'gurubk', 'siswa']),
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->userable_type === 'App\Models\Guru' && !in_array($value, ['admin', 'gurubk'])) {
                        $fail('Role harus Admin atau Guru BK jika tipe data user adalah Guru.');
                    }
                    if ($request->userable_type === 'App\Models\Siswa' && $value !== 'siswa') {
                        $fail('Role harus Siswa jika tipe data user adalah Siswa.');
                    }
                }
            ],
            'userable_id' => [
                'required',
                'integer',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('userable_id', $request->userable_id)
                        ->where('userable_type', $request->userable_type);
                }),
            ],
            'userable_type' => [
                'required',
                Rule::in(['App\Models\Guru', 'App\Models\Siswa']),
            ],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'userable_id' => $request->userable_id,
            'userable_type' => $request->userable_type,
        ]);

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function editUser($id)
    {
        $title = 'Edit Pengguna';
        $user = User::findOrFail($id);
        $guru = Guru::all();
        $siswa = Siswa::all();

        return view('dashboard.admin.users.edit', compact('title', 'user', 'guru', 'siswa'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'role' => 'required|string',
            'userable_type' => [
                'required',
                Rule::in(['App\Models\Guru', 'App\Models\Siswa']),
            ],
            'userable_id' => [
                'required',
                Rule::unique('users', 'userable_id')->where(function ($query) use ($request) {
                    if ($request->filled('userable_type')) {
                        $query->where('userable_type', $request->userable_type);
                    }
                })->ignore($id),
            ],
        ]);

        $user = User::findOrFail($id);

        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'userable_id' => $request->userable_id,
            'userable_type' => $request->userable_type,
        ])->save();

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->forceDelete();

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus');
    }

    // GURU =================================================================================
    public function guru()
    {
        $title = 'Data Guru';
        $guru = Guru::orderBy('created_at', 'desc')->get();

        return view('dashboard.admin.guru.index', compact('title', 'guru'));
    }

    public function showGuru($id)
    {
        $title = 'Detail Guru';
        $guru = Guru::findOrFail($id);

        return view('dashboard.admin.guru.show', compact('title', 'guru'));
    }

    public function createGuru()
    {
        $title = 'Tambah Guru';
        $agama = Agama::all();
        $pendidikan_terakhir = PendidikanTerakhir::all();
        $guru = Guru::all();
        $siswa = Siswa::all();

        return view('dashboard.admin.guru.create', compact('title', 'agama', 'pendidikan_terakhir', 'guru', 'siswa'));
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'nip' => 'required|numeric|unique:gurus,nip',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'agama_id' => 'required',
            'alamat' => 'required',
            'pendidikan_terakhir_id' => 'required',

            // user
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,gurubk',
        ]);

        $guru = Guru::create([
            'nip' => $request->nip,
            'nama' => ucwords(strtolower($request->nama)),
            'tempat_lahir' => ucwords(strtolower($request->tempat_lahir)),
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama_id' => $request->agama_id,
            'alamat' => ucwords(strtolower($request->alamat)),
            'pendidikan_terakhir_id' => $request->pendidikan_terakhir_id,
        ]);

        $guru->user()->create([
            'name' => ucwords(strtolower($request->nama)),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'added_by_role' => Auth::user()->role,
        ]);

        return redirect()->route('admin.guru')->with('success', 'Guru berhasil ditambahkan');
    }

    public function editGuru($id)
    {
        $title = 'Edit Guru';
        $guru = Guru::findOrFail($id);
        $agama = Agama::all();
        $pendidikan_terakhir = PendidikanTerakhir::all();

        return view('dashboard.admin.guru.edit', compact('title', 'guru', 'agama', 'pendidikan_terakhir'));
    }

    public function updateGuru(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|numeric|unique:gurus,nip,' . $id,
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'agama_id' => 'required',
            'alamat' => 'required',
            'pendidikan_terakhir_id' => 'required',
        ]);

        $guru = Guru::findOrFail($id);

        $guru->update([
            'nip' => $request->nip,
            'nama' => ucwords(strtolower($request->nama)),
            'tempat_lahir' => ucwords(strtolower($request->tempat_lahir)),
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama_id' => $request->agama_id,
            'alamat' => ucwords(strtolower($request->alamat)),
            'pendidikan_terakhir_id' => $request->pendidikan_terakhir_id,
        ]);

        return redirect()->route('admin.guru')->with('success', 'Guru berhasil diperbarui');
    }

    public function destroyGuru($id)
    {
        $guru = Guru::findOrFail($id);

        $guru->forceDelete();

        return redirect()->route('admin.guru')->with('success', 'Guru berhasil dihapus');
    }

    // SISWA =================================================================================
    public function siswa()
    {
        $title = 'Data Siswa';
        $siswa = Siswa::orderBy('created_at', 'desc')->get();

        return view('dashboard.admin.siswa.index', compact('title', 'siswa'));
    }

    public function showSiswa($id)
    {
        $title = 'Detail Siswa';
        $siswa = Siswa::findOrFail($id);

        return view('dashboard.admin.siswa.show', compact('title', 'siswa'));
    }

    public function createSiswa()
    {
        $title = 'Tambah Siswa';
        $agama = Agama::all();
        $kelas = Kelas::all();
        $pekerjaan = Pekerjaan::all();
        $tahunAkademikAktif = TahunAkademik::where('is_active', 1)->first();

        if (!$tahunAkademikAktif) {
            return redirect()->route('admin.siswa')->with([
                'error' => 'Tahun akademik aktif belum tersedia. Silakan tambahkan terlebih dahulu.',
            ]);
        }

        return view('dashboard.admin.siswa.create', compact('title', 'agama', 'kelas', 'pekerjaan'));
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'nisn' => 'required|numeric|unique:siswas,nisn',
            'nama' => 'required',
            // 'tempat_lahir' => 'required',
            // 'tanggal_lahir' => 'required|date|before:today',
            // 'jenis_kelamin' => 'required|in:L,P',
            // 'agama_id' => 'required',
            // 'kelas_id' => 'required',
            // 'alamat' => 'required',
            // 'tahun_masuk' => 'required|numeric|digits:4',
            // // ayah
            // 'nik_ayah' => 'required|numeric|unique:siswas,nik_ayah',
            // 'nama_ayah' => 'required',
            // 'tempat_lahir_ayah' => 'required',
            // 'tanggal_lahir_ayah' => 'required|date|before:today',
            // 'pekerjaan_ayah_id' => 'required',
            // // ibu
            // 'nik_ibu' => 'required|numeric|unique:siswas,nik_ibu',
            // 'nama_ibu' => 'required',
            // 'tempat_lahir_ibu' => 'required',
            // 'tanggal_lahir_ibu' => 'required|date|before:today',
            // 'pekerjaan_ibu_id' => 'required',
            // user
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $tahunAkademikAktif = TahunAkademik::where('is_active', 1)->first();

        $siswa = Siswa::create([
            'nisn' => $request->nisn,
            'nama' => ucwords(strtolower($request->nama)),
            'tempat_lahir' => ucwords(strtolower($request->tempat_lahir)) ?? null,
            'tanggal_lahir' => $request->tanggal_lahir ?? null,
            'jenis_kelamin' => $request->jenis_kelamin ?? null,
            'agama_id' => $request->agama_id ?? null,
            'kelas_id' => $request->kelas_id ?? null,
            'alamat' => ucwords(strtolower($request->alamat)) ?? null,
            'tahun_masuk' => $request->tahun_masuk ?? null,
            // ayah
            'nik_ayah' => $request->nik_ayah ?? null,
            'nama_ayah' => ucwords(strtolower($request->nama_ayah)) ?? null,
            'tempat_lahir_ayah' => ucwords(strtolower($request->tempat_lahir_ayah)) ?? null,
            'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah ?? null,
            'pekerjaan_ayah_id' => $request->pekerjaan_ayah_id ?? null,
            // ibu
            'nik_ibu' => $request->nik_ibu ?? null,
            'nama_ibu' => ucwords(strtolower($request->nama_ibu)) ?? null,
            'tempat_lahir_ibu' => ucwords(strtolower($request->tempat_lahir_ibu)) ?? null,
            'tanggal_lahir_ibu' => $request->tanggal_lahir_ibu ?? null,
            'pekerjaan_ibu_id' => $request->pekerjaan_ibu_id ?? null,
            'tahun_akademik_id' => $tahunAkademikAktif->id
        ]);

        $siswa->user()->create([
            'name' => ucwords(strtolower($request->nama)),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'added_by_role' => Auth::user()->role,
        ]);

        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function editSiswa($id)
    {
        $title = 'Edit Siswa';
        $siswa = Siswa::findOrFail($id);
        $agama = Agama::all();
        $kelas = Kelas::all();
        $pekerjaan = Pekerjaan::all();

        return view('dashboard.admin.siswa.edit', compact('title', 'siswa', 'agama', 'kelas', 'pekerjaan'));
    }

    public function updateSiswa(Request $request, $id)
    {
        $request->validate([
            'nisn' => 'required|numeric|unique:siswas,nisn,' . $id,
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'agama_id' => 'required',
            'kelas_id' => 'required',
            'alamat' => 'required',
            'tahun_masuk' => 'required|numeric|digits:4',
            // ayah
            'nik_ayah' => 'required|numeric',
            'nama_ayah' => 'required',
            'tempat_lahir_ayah' => 'required',
            'tanggal_lahir_ayah' => 'required|date|before:today',
            'pekerjaan_ayah_id' => 'required',
            // ibu
            'nik_ibu' => 'required|numeric',
            'nama_ibu' => 'required',
            'tempat_lahir_ibu' => 'required',
            'tanggal_lahir_ibu' => 'required|date|before:today',
            'pekerjaan_ibu_id' => 'required',
        ]);

        $siswa = Siswa::findOrFail($id);

        $siswa->update([
            'nisn' => $request->nisn,
            'nama' => ucwords(strtolower($request->nama)),
            'tempat_lahir' => ucwords(strtolower($request->tempat_lahir)),
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama_id' => $request->agama_id,
            'kelas_id' => $request->kelas_id,
            'alamat' => ucwords(strtolower($request->alamat)),
            'tahun_masuk' => $request->tahun_masuk,
            // ayah
            'nik_ayah' => $request->nik_ayah,
            'nama_ayah' => ucwords(strtolower($request->nama_ayah)),
            'tempat_lahir_ayah' => ucwords(strtolower($request->tempat_lahir_ayah)),
            'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah,
            'pekerjaan_ayah_id' => $request->pekerjaan_ayah_id,
            // ibu
            'nik_ibu' => $request->nik_ibu,
            'nama_ibu' => ucwords(strtolower($request->nama_ibu)),
            'tempat_lahir_ibu' => ucwords(strtolower($request->tempat_lahir_ibu)),
            'tanggal_lahir_ibu' => $request->tanggal_lahir_ibu,
            'pekerjaan_ibu_id' => $request->pekerjaan_ibu_id,
        ]);

        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil diperbarui');
    }

    public function destroySiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->forceDelete();

        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil dihapus');
    }
}
