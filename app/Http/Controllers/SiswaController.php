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
use App\Helpers\SupabaseUploader;
use App\Models\Konseling;
use App\Models\Rating;
use DateTime;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        $emptyFields = $siswa->checkCompletion(); // Ambil field kosong
        $labels = [
            'nisn' => 'NISN',
            'nama' => 'Nama',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'alamat' => 'Alamat',
            'agama_id' => 'Agama',
            'kelas_id' => 'Kelas',
            'no_hp' => 'No HP',
            'foto' => 'Foto',
            'nik_ayah' => 'NIK Ayah',
            'nama_ayah' => 'Nama Ayah',
            'tempat_lahir_ayah' => 'Tempat Lahir Ayah',
            'tanggal_lahir_ayah' => 'Tanggal Lahir Ayah',
            'pekerjaan_ayah_id' => 'Pekerjaan Ayah',
            'nik_ibu' => 'NIK Ibu',
            'nama_ibu' => 'Nama Ibu',
            'tempat_lahir_ibu' => 'Tempat Lahir Ibu',
            'tanggal_lahir_ibu' => 'Tanggal Lahir Ibu',
            'pekerjaan_ibu_id' => 'Pekerjaan Ibu',
        ];

        $missingFields = collect($emptyFields)->map(fn($key) => $labels[$key] ?? $key)->toArray();

        return view('frontend.profile.index', compact('title', 'siswa', 'agama', 'pekerjaans', 'missingFields'));
    }

    public function editProfile()
    {
        $title = 'Edit Profile Siswa';
        $userId = Auth::user()->userable_id;
        $siswa = Siswa::with(['agama', 'kelas', 'pekerjaanAyah', 'pekerjaanIbu'])->find($userId);
        $agama = Agama::all();
        $pekerjaans = Pekerjaan::all();

        $emptyFields = $siswa->checkCompletion(); // Ambil field kosong
        $labels = [
            'nisn' => 'NISN',
            'nama' => 'Nama',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'alamat' => 'Alamat',
            'agama_id' => 'Agama',
            'kelas_id' => 'Kelas',
            'no_hp' => 'No HP',
            'foto' => 'Foto',
            'nik_ayah' => 'NIK Ayah',
            'nama_ayah' => 'Nama Ayah',
            'tempat_lahir_ayah' => 'Tempat Lahir Ayah',
            'tanggal_lahir_ayah' => 'Tanggal Lahir Ayah',
            'pekerjaan_ayah_id' => 'Pekerjaan Ayah',
            'nik_ibu' => 'NIK Ibu',
            'nama_ibu' => 'Nama Ibu',
            'tempat_lahir_ibu' => 'Tempat Lahir Ibu',
            'tanggal_lahir_ibu' => 'Tanggal Lahir Ibu',
            'pekerjaan_ibu_id' => 'Pekerjaan Ibu',
        ];

        $missingFields = collect($emptyFields)->map(fn($key) => $labels[$key] ?? $key)->toArray();

        return view('frontend.profile.index', compact('title', 'siswa', 'agama', 'pekerjaans', 'missingFields'));
    }

    public function editPassword()
    {
        $title = 'Edit Password Siswa';
        $userId = Auth::user()->userable_id;
        $siswa = Siswa::with(['agama', 'kelas', 'pekerjaanAyah', 'pekerjaanIbu'])->find($userId);
        $agama = Agama::all();
        $pekerjaans = Pekerjaan::all();

        $emptyFields = $siswa->checkCompletion(); // Ambil field kosong
        $labels = [
            'nisn' => 'NISN',
            'nama' => 'Nama',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'alamat' => 'Alamat',
            'agama_id' => 'Agama',
            'kelas_id' => 'Kelas',
            'no_hp' => 'No HP',
            'foto' => 'Foto',
            'nik_ayah' => 'NIK Ayah',
            'nama_ayah' => 'Nama Ayah',
            'tempat_lahir_ayah' => 'Tempat Lahir Ayah',
            'tanggal_lahir_ayah' => 'Tanggal Lahir Ayah',
            'pekerjaan_ayah_id' => 'Pekerjaan Ayah',
            'nik_ibu' => 'NIK Ibu',
            'nama_ibu' => 'Nama Ibu',
            'tempat_lahir_ibu' => 'Tempat Lahir Ibu',
            'tanggal_lahir_ibu' => 'Tanggal Lahir Ibu',
            'pekerjaan_ibu_id' => 'Pekerjaan Ibu',
        ];

        $missingFields = collect($emptyFields)->map(fn($key) => $labels[$key] ?? $key)->toArray();

        return view('frontend.profile.index', compact('title', 'siswa', 'agama', 'pekerjaans', 'missingFields'));
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

        $emptyFields = $siswa->checkCompletion();

        if (!empty($emptyFields)) {
            $fieldNames = implode(', ', $emptyFields);
            return redirect()->route('siswa.profile.show')
                ->with('warning', 'Data berhasil diperbarui, namun masih ada data yang belum lengkap: ' . $fieldNames);
        }

        return redirect()->route('siswa.profile.show')->with('success', 'Data berhasil diperbarui dan sudah lengkap');
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

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8|same:password',
        ], [
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong',
            'password_confirmation.same' => 'Konfirmasi password tidak sesuai',
        ]);

        $userId = Auth::user()->userable_id;
        $siswa = Siswa::find($userId);
        $siswa->user->update([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ]);

        return redirect()->route('siswa.profile.show')->with('success', 'Password berhasil diperbarui');
    }

    public function deleteFoto()
    {
        $user = Auth::user()->userable;
        $user->foto = null;
        $user->save();
        return redirect()->back()->with('success', 'Foto berhasil dihapus');
    }

    public function dashboard()
    {
        $title = 'Dashboard Siswa';
        $userId = Auth::user()->userable_id;
        $myKonselingCount = Siswa::find($userId)->konseling()->count();
        $myKonselingProses = Siswa::find($userId)->konseling()->where('status_id', '!=', 3)->count();
        $myKonselingSelesai = Siswa::find($userId)->konseling()->where('status_id', 3)->count();
        $myRatingCount = Rating::where('siswa_id', $userId)->count();
        $dataPerBulan = Konseling::where('siswa_id', $userId)
            ->selectRaw('MONTH(tanggal_konseling) as bulan, COUNT(*) as jumlah')
            ->groupBy('bulan')
            ->pluck('jumlah', 'bulan');

        $bulanLabels = collect(range(1, 12))->map(function ($i) {
            return DateTime::createFromFormat('!m', $i)->format('M');
        });

        $jumlahPerBulan = $bulanLabels->map(function ($label, $i) use ($dataPerBulan) {
            return $dataPerBulan->get($i + 1, 0);
        });


        return view('frontend.dashboard.index', compact(
            'title',
            'myKonselingCount',
            'myKonselingProses',
            'myKonselingSelesai',
            'myRatingCount',
            'dataPerBulan',
            'bulanLabels',
            'jumlahPerBulan'
        ));
    }
}
