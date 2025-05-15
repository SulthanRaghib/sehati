<?php

namespace App\Http\Controllers;

use App\Models\KategoriKonseling;
use Illuminate\Http\Request;

class KategoriKonselingController extends Controller
{
    public function index()
    {
        $title = 'Data Kategori Konseling';
        $kategoriKonseling = KategoriKonseling::all();


        return view('dashboard.data_master.kategori_konseling.index', compact('title', 'kategoriKonseling'));
    }

    public function create()
    {
        $title = 'Tambah Data Kategori Konseling';

        return view('dashboard.data_master.kategori_konseling.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_kategori' => 'required|unique:kategori_konselings',
                'contoh_kategori' => [
                    'required',
                    'regex:/^([a-zA-Z\s]+,\s*)+[a-zA-Z\s]+$/'
                ]
            ],
            [
                'nama_kategori.required' => 'Nama kategori konseling tidak boleh kosong.',
                'nama_kategori.unique' => 'Nama kategori konseling sudah terdaftar.',
                'contoh_kategori.required' => 'Contoh kategori konseling tidak boleh kosong.',
                'contoh_kategori.regex' => 'Contoh kategori harus berisi minimal dua kata yang dipisahkan koma. Contoh: Kecemasan, Depresi, Stres.',
            ]
        );

        KategoriKonseling::create([
            'nama_kategori' => ucwords(strtolower($request->nama_kategori)),
            'contoh_kategori' => ucwords(strtolower($request->contoh_kategori)),
        ]);

        return redirect()->route('admin.kategoriKonseling')->with('success', 'Data kategori konseling berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit Data Kategori Konseling';
        $kategoriKonseling = KategoriKonseling::findOrFail($id);

        return view('dashboard.data_master.kategori_konseling.edit', compact('title', 'kategoriKonseling'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori_konselings,nama_kategori,' . $id,
            'contoh_kategori' => [
                'required',
                'regex:/^([a-zA-Z\s]+,\s*)+[a-zA-Z\s]+$/'
            ]
        ], [
            'nama_kategori.required' => 'Nama kategori konseling tidak boleh kosong.',
            'nama_kategori.unique' => 'Nama kategori konseling sudah terdaftar.',
            'contoh_kategori.required' => 'Contoh kategori konseling tidak boleh kosong.',
            'contoh_kategori.regex' => 'Contoh kategori harus berisi minimal dua kata yang dipisahkan koma. Contoh: Kecemasan, Depresi, Stres.',
        ]);

        $kategoriKonseling = KategoriKonseling::findOrFail($id);
        $kategoriKonseling->update([
            'nama_kategori' => ucwords(strtolower($request->nama_kategori)),
            'contoh_kategori' => ucwords(strtolower($request->contoh_kategori)),
        ]);

        return redirect()->route('admin.kategoriKonseling')->with('success', 'Data kategori konseling berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategoriKonseling = KategoriKonseling::findOrFail($id);
        $kategoriKonseling->delete();

        return redirect()->route('admin.kategoriKonseling')->with('success', 'Data kategori konseling berhasil dihapus.');
    }
}
