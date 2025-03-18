<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Guru;
use App\Models\PendidikanTerakhir;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard Admin';
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
        $user = User::all();

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
            'role' => 'required|in:admin,guru,siswa',
            'userable_id' => 'required|integer',
            'userable_type' => 'required|string',
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

        return view('dashboard.admin.users.edit', compact('title', 'user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

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

        return view('dashboard.admin.guru.create', compact('title', 'agama', 'pendidikan_terakhir'));
    }

    public function storeGuru(Request $request)
    {
        $validatedData = $request->validate([
            'nip' => 'required|numeric|unique:gurus,nip',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'agama_id' => 'required',
            'alamat' => 'required',
            'pendidikan_terakhir_id' => 'required',
        ]);

        $validatedData['nama'] = ucwords(strtolower($validatedData['nama']));
        $validatedData['tempat_lahir'] = ucwords(strtolower($validatedData['tempat_lahir']));
        $validatedData['alamat'] = ucwords(strtolower($validatedData['alamat']));

        Guru::create($validatedData);

        return redirect()->route('admin.guru')->with('success', 'Guru berhasil ditambahkan');
    }

    public function editGuru($id)
    {
        $title = 'Edit Guru';
        $guru = Guru::findOrFail($id);

        return view('dashboard.admin.guru.edit', compact('title', 'guru'));
    }

    public function updateGuru(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $guru = Guru::findOrFail($id);

        $guru->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.guru')->with('success', 'Guru berhasil diperbarui');
    }

    public function destroyGuru($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.guru')->with('success', 'Guru berhasil dihapus');
    }
}
