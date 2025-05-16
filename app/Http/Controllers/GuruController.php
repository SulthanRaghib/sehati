<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Guru;
use App\Models\PendidikanTerakhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SawaStacks\Utils\Kropify;

class GuruController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard Guru BK';
        $user = Auth::user();

        $guru = $user->userable_type == 'App\Models\Guru' ? $user->userable : null;


        return view('dashboard.index', compact('title', 'user', 'guru'));
    }

    public function profileGuru()
    {
        $title = 'Profile Guru';
        $user = Auth::user();
        $list_agama = Agama::all();
        $list_pendidikan = PendidikanTerakhir::all();

        $guru = $user->userable_type == 'App\Models\Guru' ? $user->userable : null;
        return view('dashboard.admin.guru.profile', compact('title', 'user', 'guru', 'list_agama', 'list_pendidikan'));
    }

    public function updateProfile(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:gurus,nip,' . $guru->id,
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'agama_id' => 'required|exists:agamas,id',
            'pendidikan_terakhir_id' => 'required|exists:pendidikan_terakhirs,id',
            'alamat' => 'nullable|string',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'nip.required' => 'NIP tidak boleh kosong',
            'nip.unique' => 'NIP sudah terdaftar',
            'tempat_lahir.max' => 'Tempat lahir maksimal 100 karakter',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid',
            'tanggal_lahir.before' => 'Tanggal lahir tidak boleh lebih dari hari ini',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
            'agama_id.required' => 'Agama tidak boleh kosong',
            'agama_id.exists' => 'Agama tidak valid',
            'pendidikan_terakhir_id.required' => 'Pendidikan terakhir tidak boleh kosong',
            'pendidikan_terakhir_id.exists' => 'Pendidikan terakhir tidak valid',
        ]);

        $guru->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }


    public function uploadFoto(Request $request)
    {
        try {
            $guruID = Auth::user()->userable_id;
            $guru = Guru::find($guruID);

            $file = $request->file('foto');
            if (!$file) {
                return response()->json(['status' => 'error', 'message' => 'File tidak ditemukan'], 400);
            }

            $path = 'img/guru/';
            $old_picture = $guru->foto;
            $originalExtension = $file->getClientOriginalExtension();
            $extension = preg_replace('/[^a-z0-9]/', '', strtolower(ltrim($originalExtension, '.')));

            if (!$extension) {
                $mime = $file->getMimeType();
                $extension = explode('/', $mime)[1] ?? 'jpg';
            }

            $filename = time() . '.' . $extension;
            $fullStoragePath = storage_path('app/public/' . $path);

            $upload = Kropify::getFile($file, $filename)
                ->maxWoH(255)
                ->save($fullStoragePath);

            $imageSize = $upload->getSize();
            if ($imageSize > 2097152) {
                if (file_exists($fullStoragePath . '/' . $filename)) {
                    unlink($fullStoragePath . '/' . $filename);
                }

                return response()->json([
                    'status' => 'error',
                    'message' => 'Ukuran gambar hasil crop melebihi batas maksimum 2 MB.',
                    'size' => $imageSize
                ], 400);
            }

            if ($upload) {
                if ($old_picture && Storage::disk('public')->exists($path . $old_picture)) {
                    Storage::disk('public')->delete($path . $old_picture);
                }

                $guru->update(['foto' => $filename]);

                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan foto'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan server'], 500);
        }
    }
}
