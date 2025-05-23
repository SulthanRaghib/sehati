<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\ArtikelKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    public function index()
    {
        $title = 'Artikel';
        $artikel = Artikel::with('artikelKategori', 'user')->latest()->get();

        return view('dashboard.artikel.index', compact('title', 'artikel'));
    }

    public function create()
    {
        $title = 'Tambah Artikel';
        $kategori = ArtikelKategori::all();
        $user = Auth::user();

        return view('dashboard.artikel.create', compact('title', 'kategori', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'judul' => 'required|string|max:100',
                'slug' => 'required|string|max:100|unique:artikels',
                'isi' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'artikel_kategori_id' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if ($value !== 'add' && !\App\Models\ArtikelKategori::find($value)) {
                            $fail('Kategori tidak valid.');
                        }
                    },
                ],
                'kategori_baru' => 'required_if:artikel_kategori_id,add',
                'sumber' => 'nullable|string|max:255',
                'status' => 'required|in:draft,publish',
            ],
            [
                'judul.required' => 'Judul artikel tidak boleh kosong.',
                'judul.string' => 'Judul artikel harus berupa teks.',
                'slug.required' => 'Slug artikel tidak boleh kosong.',
                'slug.string' => 'Slug artikel harus berupa teks.',
                'slug.unique' => 'Slug artikel sudah terdaftar.',
                'isi.required' => 'Isi artikel tidak boleh kosong.',
                'isi.string' => 'Isi artikel harus berupa teks.',
                'gambar.image' => 'File yang diunggah harus berupa gambar.',
                'gambar.mimes' => 'Format gambar tidak valid. Hanya mendukung jpeg, png, jpg, gif.',
                'gambar.max' => 'Ukuran gambar maksimal 2MB.',
                'artikel_kategori_id.required' => 'Kategori artikel tidak boleh kosong.',
                'kategori_baru.required_if' => 'Nama kategori baru tidak boleh kosong jika kategori baru dipilih.',
                'sumber.string' => 'Sumber artikel harus berupa teks.',
                'status.required' => 'Status artikel tidak boleh kosong.',
            ]
        );

        if ($request->artikel_kategori_id === 'add') {
            $kategoriBaru = ArtikelKategori::create([
                'nama' => ucwords(strtolower($request->kategori_baru)),
                'slug' => Str::slug($request->kategori_baru)
            ]);
            $kategoriId = $kategoriBaru->id;
        } else {
            $kategoriId = $request->artikel_kategori_id;
        }

        $gambarPath = null;

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('artikel', 'public');
        }

        $artikel = Artikel::create([
            'judul' => ucwords(strtolower($request->judul)),
            'slug' => $request->slug,
            'isi' => $request->isi,
            'gambar' => $gambarPath,
            'artikel_kategori_id' => $kategoriId,
            'user_id' => Auth::user()->id,
            'sumber' => $request->sumber,
            'tanggal_terbit' => now(),
            'status' => $request->status,
        ]);

        return redirect()->route('artikel')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit Artikel';
        $artikel = Artikel::with('artikelKategori', 'user')->findOrFail($id);
        $kategori = ArtikelKategori::all();
        $user = Auth::user();

        return view('dashboard.artikel.edit', compact('title', 'artikel', 'kategori', 'user'));
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $request->validate(
            [
                'judul' => 'required|string|max:100',
                'slug' => 'required|string|max:100|unique:artikels,slug,' . $artikel->id,
                'isi' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'artikel_kategori_id' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if ($value !== 'add' && !\App\Models\ArtikelKategori::find($value)) {
                            $fail('Kategori tidak valid.');
                        }
                    },
                ],
                'kategori_baru' => 'required_if:artikel_kategori_id,add',
                'sumber' => 'nullable|string|max:255',
                'status' => 'required|in:draft,publish',
            ],
            [
                'judul.required' => 'Judul artikel tidak boleh kosong.',
                'judul.string' => 'Judul artikel harus berupa teks.',
                'slug.required' => 'Slug artikel tidak boleh kosong.',
                'slug.string' => 'Slug artikel harus berupa teks.',
                'slug.unique' => 'Slug artikel sudah terdaftar.',
                'isi.required' => 'Isi artikel tidak boleh kosong.',
                'isi.string' => 'Isi artikel harus berupa teks.',
                'gambar.image' => 'File yang diunggah harus berupa gambar.',
                'gambar.mimes' => 'Format gambar tidak valid. Hanya mendukung jpeg, png, jpg, gif.',
                'gambar.max' => 'Ukuran gambar maksimal 2MB.',
                'artikel_kategori_id.required' => 'Kategori artikel tidak boleh kosong.',
                'kategori_baru.required_if' => 'Nama kategori baru tidak boleh kosong jika kategori baru dipilih.',
                'sumber.string' => 'Sumber artikel harus berupa teks.',
                'status.required' => 'Status artikel tidak boleh kosong.',
            ]
        );

        if ($request->artikel_kategori_id === 'add') {
            $kategoriBaru = ArtikelKategori::create([
                'nama' => ucwords(strtolower($request->kategori_baru)),
                'slug' => Str::slug($request->kategori_baru)
            ]);
            $kategoriId = $kategoriBaru->id;
        } else {
            $kategoriId = $request->artikel_kategori_id;
        }

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada dan file-nya memang eksis
            if ($artikel->gambar && Storage::disk('public')->exists($artikel->gambar)) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('artikel', 'public');
        } else {
            // Tetap gunakan gambar lama
            $gambarPath = $artikel->gambar;
        }


        $artikel->update([
            'judul' => ucwords(strtolower($request->judul)),
            'slug' => $request->slug,
            'isi' => $request->isi,
            'gambar' => $gambarPath,
            'artikel_kategori_id' => $kategoriId,
            'sumber' => $request->sumber,
            'status' => $request->status,
        ]);

        return redirect()->route('artikel')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        if ($artikel->gambar) {
            Storage::disk('public')->delete($artikel->gambar);
        }

        $artikel->delete();

        return redirect()->route('artikel')->with('success', 'Artikel berhasil dihapus.');
    }

    public function show($id)
    {
        $artikel = Artikel::with('artikelKategori', 'user')->findOrFail($id);
        $title = $artikel->judul;

        return view('dashboard.artikel.show', compact('artikel', 'title'));
    }

    public function publish($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->update(['status' => 'publish']);

        return redirect()->route('artikel')->with('success', 'Artikel berhasil dipublikasikan.');
    }

    public function draft($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->update(['status' => 'draft']);

        return redirect()->route('artikel')->with('success', 'Artikel berhasil disimpan sebagai draft.');
    }

    public function viewArtikel($slug)
    {
        $title = 'Detail Artikel';
        $artikel = Artikel::with('artikelKategori', 'user')->where('slug', $slug)->firstOrFail();
        $artikel->increment('views');
        $user = Auth::user();

        // Default nilai
        $siswa = null;

        // Cek apakah user sudah login
        if (Auth::check()) {
            // Baru akses jika user tidak null
            $siswa = $user->userable_type === 'App\Models\Siswa' ? $user->userable : null;
        }

        return view('frontend.artikel.view_detail', compact('title', 'artikel', 'siswa', 'user'));
    }
}
