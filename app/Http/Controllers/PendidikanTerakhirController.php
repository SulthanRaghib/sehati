<?php

namespace App\Http\Controllers;

use App\Models\PendidikanTerakhir;
use Illuminate\Http\Request;

class PendidikanTerakhirController extends Controller
{
    public function index()
    {
        $title = 'Data Pendidikan Terakhir';
        $pendidikanTerakhir = PendidikanTerakhir::all();

        return view('dashboard.data_master.pendidikan_terakhir.index', compact('title', 'pendidikanTerakhir'));
    }

    public function create()
    {
        $title = 'Tambah Data Pendidikan Terakhir';

        return view('dashboard.data_master.pendidikan_terakhir.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|string|unique:pendidikan_terakhirs',
            ],
            [
                'nama.required' => 'Nama pendidikan terakhir tidak boleh kosong.',
                'nama.string' => 'Nama pendidikan terakhir harus berupa teks.',
                'nama.unique' => 'Nama pendidikan terakhir sudah terdaftar.',
            ]
        );

        PendidikanTerakhir::create([
            'nama' => strtoupper($request->nama),
        ]);

        return redirect()->route('admin.pendidikanTerakhir')->with('success', 'Data pendidikan terakhir berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit Data Pendidikan Terakhir';
        $pendidikanTerakhir = PendidikanTerakhir::findOrFail($id);

        return view('dashboard.data_master.pendidikan_terakhir.edit', compact('title', 'pendidikanTerakhir'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|unique:pendidikan_terakhirs,nama,' . $id,
        ], [
            'nama.required' => 'Nama pendidikan terakhir tidak boleh kosong.',
            'nama.string' => 'Nama pendidikan terakhir harus berupa teks.',
            'nama.unique' => 'Nama pendidikan terakhir sudah terdaftar.',
        ]);

        $pendidikanTerakhir = PendidikanTerakhir::findOrFail($id);
        $pendidikanTerakhir->update([
            'nama' => strtoupper($request->nama),
        ]);

        return redirect()->route('admin.pendidikanTerakhir')->with('success', 'Data pendidikan terakhir berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendidikanTerakhir = PendidikanTerakhir::findOrFail($id);
        $pendidikanTerakhir->delete();

        return redirect()->route('admin.pendidikanTerakhir')->with('success', 'Data pendidikan terakhir berhasil dihapus.');
    }
}
