<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    public function index()
    {
        $title = 'Data Pekerjaan';
        $pekerjaan = Pekerjaan::all();

        return view('dashboard.data_master.pekerjaan.index', compact('title', 'pekerjaan'));
    }

    public function create()
    {
        $title = 'Tambah Data Pekerjaan';

        return view('dashboard.data_master.pekerjaan.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|string|unique:pekerjaans',
            ],
            [
                'nama.required' => 'Nama pekerjaan tidak boleh kosong.',
                'nama.string' => 'Nama pekerjaan harus berupa teks.',
                'nama.unique' => 'Nama pekerjaan sudah terdaftar.',
            ]
        );

        Pekerjaan::create([
            'nama' => ucwords(strtolower($request->nama)),
        ]);

        return redirect()->route('admin.pekerjaan')->with('success', 'Data pekerjaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit Data Pekerjaan';
        $pekerjaan = Pekerjaan::findOrFail($id);

        return view('dashboard.data_master.pekerjaan.edit', compact('title', 'pekerjaan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|unique:pekerjaans,nama,' . $id,
        ], [
            'nama.required' => 'Nama pekerjaan tidak boleh kosong.',
            'nama.string' => 'Nama pekerjaan harus berupa teks.',
            'nama.unique' => 'Nama pekerjaan sudah terdaftar.',
        ]);

        $pekerjaan = Pekerjaan::findOrFail($id);
        $pekerjaan->update([
            'nama' => ucwords(strtolower($request->nama)),
        ]);

        return redirect()->route('admin.pekerjaan')->with('success', 'Data pekerjaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $pekerjaan->delete();

        return redirect()->route('admin.pekerjaan')->with('success', 'Data pekerjaan berhasil dihapus.');
    }
}
