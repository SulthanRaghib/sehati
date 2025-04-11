<?php

namespace App\Http\Controllers;

use App\Models\ArtikelKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArtikelKategoriController extends Controller
{
    public function index()
    {
        $title = 'Kategori Artikel';
        $artikelKategori = ArtikelKategori::all();

        return view('dashboard.data_master.kategori_artikel.index', compact('title', 'artikelKategori'));
    }

    public function create()
    {
        $title = 'Tambah Kategori Artikel';

        return view('dashboard.data_master.kategori_artikel.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->nama, '-');
        // Check if slug already exists
        $existingSlug = ArtikelKategori::where('slug', $slug)->first();
        if ($existingSlug) {
            return redirect()->back()->withErrors(['slug' => 'Slug already exists.']);
        }

        ArtikelKategori::create([
            'nama' => ucwords(strtolower($request->nama)),
            'slug' => $slug,
        ]);

        return redirect()->route('admin.artikelKategori')->with('success', 'Kategori Artikel berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit Kategori Artikel';
        $artikelKategori = ArtikelKategori::findOrFail($id);

        return view('dashboard.data_master.kategori_artikel.edit', compact('title', 'artikelKategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $artikelKategori = ArtikelKategori::findOrFail($id);
        $slug = Str::slug($request->nama, '-');

        // Check if slug already exists
        $existingSlug = ArtikelKategori::where('slug', $slug)->where('id', '!=', $id)->first();
        if ($existingSlug) {
            return redirect()->back()->withErrors(['slug' => 'Slug already exists.']);
        }

        $artikelKategori->update([
            'nama' => ucwords(strtolower($request->nama)),
            'slug' => $slug,
        ]);

        return redirect()->route('admin.artikelKategori')->with('success', 'Kategori Artikel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $artikelKategori = ArtikelKategori::findOrFail($id);
        $artikelKategori->delete();

        return redirect()->route('admin.artikelKategori')->with('success', 'Kategori Artikel berhasil dihapus.');
    }
}
