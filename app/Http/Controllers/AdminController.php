<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Pekerjaan;
use App\Models\PendidikanTerakhir;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';
        $user = Auth::user();

        if ($user->userable_type == 'App\Models\Guru') {
            $guru = $user->userable;
        } else {
            $guru = null;
        }

        return view('dashboard.index', compact('title', 'user', 'guru'));
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

        return view('dashboard.admin.siswa.create', compact('title', 'agama', 'kelas', 'pekerjaan'));
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'nisn' => 'required|numeric|unique:siswas,nisn',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'agama_id' => 'required',
            'kelas_id' => 'required',
            'alamat' => 'required',
            // ayah
            'nik_ayah' => 'required|numeric|unique:siswas,nik_ayah',
            'nama_ayah' => 'required',
            'tempat_lahir_ayah' => 'required',
            'tanggal_lahir_ayah' => 'required|date|before:today',
            'pekerjaan_ayah_id' => 'required',
            // ibu
            'nik_ibu' => 'required|numeric|unique:siswas,nik_ibu',
            'nama_ibu' => 'required',
            'tempat_lahir_ibu' => 'required',
            'tanggal_lahir_ibu' => 'required|date|before:today',
            'pekerjaan_ibu_id' => 'required',
            // user
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $siswa = Siswa::create([
            'nisn' => $request->nisn,
            'nama' => ucwords(strtolower($request->nama)),
            'tempat_lahir' => ucwords(strtolower($request->tempat_lahir)),
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama_id' => $request->agama_id,
            'kelas_id' => $request->kelas_id,
            'alamat' => ucwords(strtolower($request->alamat)),
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
