<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Guru;
use App\Models\KategoriKonseling;
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
use Illuminate\Support\Facades\DB;
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

        // Ambil filter untuk grafik batang (blok)
        $blok_bulan = $request->blok_bulan;
        $blok_tahun = $request->blok_tahun;

        // Ambil filter untuk grafik donat
        $donat_bulan = $request->donat_bulan;
        $donat_tahun = $request->donat_tahun;

        // ===================== GRAFIK BATANG =====================
        $blokQuery = Konseling::query();

        if ($blok_bulan) {
            $blokQuery->whereMonth('tanggal_konseling', $blok_bulan);
        }

        if ($blok_tahun) {
            $blokQuery->whereYear('tanggal_konseling', $blok_tahun);
        }

        $konselings = $blokQuery->get();

        // Generate chart batang
        $chartLabels = [];
        $chartData = [];

        if ($blok_bulan && $blok_tahun) {
            $daysInMonth = Carbon::create($blok_tahun, $blok_bulan)->daysInMonth;

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $start = Carbon::create($blok_tahun, $blok_bulan, $day)->startOfDay();
                $end = Carbon::create($blok_tahun, $blok_bulan, $day)->endOfDay();

                $chartLabels[] = $day;
                $chartData[] = $konselings->whereBetween('tanggal_konseling', [$start, $end])->count();
            }
        } elseif ($blok_tahun && !$blok_bulan) {
            for ($m = 1; $m <= 12; $m++) {
                $count = $konselings->filter(function ($item) use ($m) {
                    return $item->tanggal_konseling->month == $m;
                })->count();

                $chartLabels[] = DateTime::createFromFormat('!m', $m)->format('F');
                $chartData[] = $count;
            }
        } elseif ($blok_bulan && !$blok_tahun) {
            $blok_tahun = now()->year;
            $daysInMonth = Carbon::create($blok_tahun, $blok_bulan)->daysInMonth;

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $start = Carbon::create($blok_tahun, $blok_bulan, $day)->startOfDay();
                $end = Carbon::create($blok_tahun, $blok_bulan, $day)->endOfDay();

                $chartLabels[] = $day;
                $chartData[] = $konselings->whereBetween('tanggal_konseling', [$start, $end])->count();
            }
        } else {
            // Default: bulan dan tahun saat ini
            $blok_bulan = now()->month;
            $blok_tahun = now()->year;
            $daysInMonth = Carbon::create($blok_tahun, $blok_bulan)->daysInMonth;

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $start = Carbon::create($blok_tahun, $blok_bulan, $day)->startOfDay();
                $end = Carbon::create($blok_tahun, $blok_bulan, $day)->endOfDay();

                $chartLabels[] = $day;
                $chartData[] = Konseling::whereBetween('tanggal_konseling', [$start, $end])->count();
            }
        }

        // ===================== GRAFIK DONAT =====================
        $topQuery = Konseling::query();

        if ($donat_bulan) {
            $topQuery->whereMonth('tanggal_konseling', $donat_bulan);
        }

        if ($donat_tahun) {
            $topQuery->whereYear('tanggal_konseling', $donat_tahun);
        }

        $topSiswa = $topQuery->with('siswa')
            ->select('siswa_id', DB::raw('count(*) as total'))
            ->groupBy('siswa_id')
            ->orderByDesc('total')
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => optional($item->siswa)->nama ?? 'Tidak diketahui',
                    'total' => $item->total
                ];
            });

        // TOPIK POPULER
        $topikPopuler = Konseling::join('kategori_konselings', 'konselings.kategori_konseling_id', '=', 'kategori_konselings.id')
            ->select('kategori_konselings.nama_kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori_konselings.nama_kategori')
            ->orderByDesc('total')
            ->limit(4)
            ->pluck('total', 'kategori_konselings.nama_kategori')
            ->toArray();


        // Ambil total data Guru BK, validasi dari user role gurubk
        $guruCount = User::where('role', 'gurubk')->count();

        // Ambil total data konseling
        $konselingCount = Konseling::count();

        // Ambil total siswa yang sudah melakukan konseling
        $siswaCount = Siswa::whereHas('konseling')->count();

        return view('dashboard.index', compact(
            'title',
            'user',
            'guru',
            'guruCount',
            'konselingCount',
            'siswaCount',
            'topSiswa',
            'chartLabels',
            'chartData',
            'blok_bulan',
            'blok_tahun',
            'donat_bulan',
            'donat_tahun',
            'topikPopuler'
        ));
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

        // Tambahkan flag apakah bisa reset password
        $user->map(function ($item) use ($u) {
            $item->canReset = false;

            if ($u->role === 'admin') {
                $item->canReset = true; // Admin bisa semua
            } elseif ($u->role === 'gurubk' && in_array($item->role, ['guru', 'siswa'])) {
                $item->canReset = true; // Guru BK hanya guru/siswa
            }

            return $item;
        });

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
            'role' => [
                'required',
                Rule::in(['admin', 'gurubk', 'siswa']),
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->userable_type === 'App\Models\Guru' && !in_array($value, ['admin', 'gurubk'])) {
                        $fail('Role harus Guru BK jika Tipe Pemilik User adalah Guru.');
                    }
                    if ($request->userable_type === 'App\Models\Siswa' && $value !== 'siswa') {
                        $fail('Role harus Siswa jika Tipe Pemilik User adalah Siswa.');
                    }
                }
            ],
            'userable_type' => [
                'required',
                Rule::in(['App\Models\Guru', 'App\Models\Siswa']),
            ],
            'userable_id' => [
                'required',
                'integer',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('userable_id', $request->userable_id)
                        ->where('userable_type', $request->userable_type);
                })->ignore($id),
            ],
        ], [
            'userable_id.unique' => 'Pemilik user ini sudah terdaftar untuk tipe data yang sama.',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'userable_id' => $request->userable_id,
            'userable_type' => $request->userable_type,
        ]);

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function editUserPassword($id)
    {
        $title = 'Edit Password Pengguna';
        $user = User::findOrFail($id);

        return view('dashboard.admin.users.edit_password', compact('title', 'user'));
    }

    public function updateUserPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6|same:password',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users')->with('success', 'Password pengguna berhasil diperbarui');
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

        // Update nama di tabel user terkait
        if ($guru->user) {
            $guru->user->update([
                'name' => ucwords(strtolower($request->nama)),
            ]);
        }

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
                'tahun-akademik-not-found' => 'Tahun akademik aktif belum tersedia. Silakan tambahkan terlebih dahulu.',
            ]);
        }

        return view('dashboard.admin.siswa.create', compact('title', 'agama', 'kelas', 'pekerjaan'));
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            // siswa
            'nisn' => 'required|numeric|unique:siswas,nisn',
            'nama' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'agama_id' => 'required',
            'kelas_id' => 'required',
            'tahun_masuk' => 'required|numeric|digits:4',
            // user
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $tahunAkademikAktif = TahunAkademik::where('is_active', 1)->first();

        $siswa = Siswa::create([
            'nisn' => $request->nisn,
            'nama' => ucwords(strtolower($request->nama)),
            'jenis_kelamin' => $request->jenis_kelamin ?? null,
            'agama_id' => $request->agama_id ?? null,
            'kelas_id' => $request->kelas_id ?? null,
            'tahun_masuk' => $request->tahun_masuk ?? null,
            'tahun_akademik_id' => $tahunAkademikAktif->id,
        ]);

        $user = $siswa->user()->create([
            'name' => ucwords(strtolower($request->nama)),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'added_by_role' => Auth::user()->role,
        ]);
        // Sekarang user-nya sudah tersimpan dan bisa dipakai
        $token = Str::random(60);

        // Simpan token ke user kalau memang kamu perlu (optional)
        $user->remember_token = $token;
        $user->save();

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
            'jenis_kelamin' => 'required|in:L,P',
            'agama_id' => 'required',
            'kelas_id' => 'required',
            'tahun_masuk' => 'required|numeric|digits:4',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'date|before:today|nullable',
            'alamat' => 'nullable',
            'no_hp' => 'nullable|numeric',
            // ayah
            'nik_ayah' => 'numeric|nullable',
            'nama_ayah' => 'nullable',
            'tempat_lahir_ayah' => 'nullable',
            'tanggal_lahir_ayah' => 'date|before:today|nullable',
            'pekerjaan_ayah_id' => 'nullable|exists:pekerjaans,id',
            // ibu
            'nik_ibu' => 'numeric|nullable',
            'nama_ibu' => 'nullable',
            'tempat_lahir_ibu' => 'nullable',
            'tanggal_lahir_ibu' => 'date|before:today|nullable',
            'pekerjaan_ibu_id' => 'nullable|exists:pekerjaans,id',
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
