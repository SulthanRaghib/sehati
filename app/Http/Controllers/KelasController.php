<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $title = 'Data Kelas';
        $kelas = Kelas::all();

        return view('dashboard.data_master.kelas.index', compact('title', 'kelas'));
    }

    public function create()
    {
        $title = 'Tambah Data Kelas';

        return view('dashboard.data_master.kelas.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'tingkat' => 'required|numeric|unique:kelas',
            ],
            [
                'tingkat.required' => 'Tingkat kelas tidak boleh kosong.',
                'tingkat.numeric' => 'Tingkat kelas harus berupa angka.',
                'tingkat.unique' => 'Tingkat kelas sudah terdaftar.',
            ]
        );

        Kelas::create($request->all());

        return redirect()->route('admin.kelas')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit Data Kelas';
        $kelas = Kelas::findOrFail($id);

        return view('dashboard.data_master.kelas.edit', compact('title', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tingkat' => 'required|numeric|unique:kelas,tingkat,' . $id,
        ], [
            'tingkat.required' => 'Tingkat kelas tidak boleh kosong.',
            'tingkat.numeric' => 'Tingkat kelas harus berupa angka.',
            'tingkat.unique' => 'Tingkat kelas sudah terdaftar.',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('admin.kelas')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('admin.kelas')->with('success', 'Data kelas berhasil dihapus.');
    }
}
