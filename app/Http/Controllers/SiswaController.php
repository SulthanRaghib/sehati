<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SawaStacks\Utils\Kropify;


class SiswaController extends Controller
{
    public function home()
    {
        $title = 'Homepage';
        $user = Auth::user();

        if ($user->userable_type == 'App\Models\Siswa') {
            $siswa = $user->userable;
        } else {
            $siswa = null;
        }

        return view('frontend.index', compact('title', 'user', 'siswa'));
    }

    public function profile()
    {
        $title = 'Profile Siswa';
        $userId = Auth::user()->userable_id;
        $siswa = Siswa::with(['agama', 'kelas', 'pekerjaanAyah', 'pekerjaanIbu'])->find($userId);
        $agama = Agama::all();
        $pekerjaans = Pekerjaan::all();

        $wajibIsi = [
            'nisn',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'alamat',
            'agama_id',
            'kelas_id',
            'no_hp',
            'nik_ayah',
            'nama_ayah',
            'tempat_lahir_ayah',
            'tanggal_lahir_ayah',
            'pekerjaan_ayah_id',
            'nik_ibu',
            'nama_ibu',
            'tempat_lahir_ibu',
            'tanggal_lahir_ibu',
            'pekerjaan_ibu_id'
        ];

        $dataKosong = [];
        foreach ($wajibIsi as $field) {
            if (empty($siswa->$field)) {
                $dataKosong[] = $field;
            }
        }

        if (!empty($dataKosong)) {
            session()->flash('warning', 'Silakan lengkapi data profil terlebih dahulu!');
        }

        return view('frontend.profile.index', compact('title', 'siswa', 'agama', 'pekerjaans'));
    }

    public function editProfile()
    {
        $title = 'Edit Profile Siswa';
        $userId = Auth::user()->userable_id;
        $siswa = Siswa::with(['agama', 'kelas', 'pekerjaanAyah', 'pekerjaanIbu'])->find($userId);
        $agama = Agama::all();
        $pekerjaans = Pekerjaan::all();

        $wajibIsi = [
            'nisn',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'alamat',
            'agama_id',
            'kelas_id',
            'no_hp',
            'nik_ayah',
            'nama_ayah',
            'tempat_lahir_ayah',
            'tanggal_lahir_ayah',
            'pekerjaan_ayah_id',
            'nik_ibu',
            'nama_ibu',
            'tempat_lahir_ibu',
            'tanggal_lahir_ibu',
            'pekerjaan_ibu_id'
        ];

        $dataKosong = [];
        foreach ($wajibIsi as $field) {
            if (empty($siswa->$field)) {
                $dataKosong[] = $field;
            }
        }

        if (!empty($dataKosong)) {
            session()->flash('warning', 'Silakan lengkapi data profil terlebih dahulu!');
        }

        return view('frontend.profile.index', compact('title', 'siswa', 'agama', 'pekerjaans'));
    }

    public function updateDataSiswa(Request $request)
    {
        $siswa = Siswa::find($request->id);

        $request->validate([
            'nisn' => 'required|numeric|unique:siswas,nisn,' . $siswa->id,
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'agama_id' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required|numeric',
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

        $siswa->update([
            'nisn' => $request->nisn,
            'nama' => ucwords(strtolower($request->nama)),
            'tempat_lahir' => ucwords(strtolower($request->tempat_lahir)),
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama_id' => $request->agama_id,
            'alamat' => ucwords(strtolower($request->alamat)),
            'no_hp' => $request->no_hp,
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

        if ($siswa) {
            return redirect()->route('siswa.profile.show')->with('success', 'Data berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Data gagal diperbarui');
        }
    }

    public function uploadFoto(Request $request)
    {
        try {
            $siswaID = Auth::user()->userable_id;
            $siswa = Siswa::find($siswaID);

            $file = $request->file('foto');
            if (!$file) {
                return response()->json(['status' => 'error', 'message' => 'File tidak ditemukan'], 400);
            }

            $path = 'img/siswa/';
            $old_picture = $siswa->foto;
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

                $siswa->update(['foto' => $filename]);

                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan foto'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function deleteFoto()
    {
        $user = Auth::user()->userable;
        $user->foto = null;
        $user->save();
        return redirect()->back()->with('success', 'Foto berhasil dihapus');
    }
}
