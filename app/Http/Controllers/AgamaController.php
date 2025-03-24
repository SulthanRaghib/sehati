<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use Illuminate\Http\Request;

class AgamaController extends Controller
{
    public function index()
    {
        $title = 'Data Agama';
        $agama = Agama::all();

        return view('dashboard.data_master.agama.index', compact('title', 'agama'));
    }

    public function create()
    {
        $title = 'Tambah Data Agama';

        return view('dashboard.data_master.agama.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
        ]);

        Agama::create([
            'nama' => ucwords(strtolower($request->nama)),
        ]);

        return redirect()->route('admin.agama')->with('success', 'Data agama berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit Data Agama';
        $agama = Agama::findOrFail($id);

        return view('dashboard.data_master.agama.edit', compact('title', 'agama'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
        ]);

        $agama = Agama::findOrFail($id);
        $agama->update([
            'nama' => ucwords(strtolower($request->nama)),
        ]);

        return redirect()->route('admin.agama')->with('success', 'Data agama berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $agama = Agama::findOrFail($id);
        $agama->delete();

        return redirect()->route('admin.agama')->with('success', 'Data agama berhasil dihapus.');
    }
}
