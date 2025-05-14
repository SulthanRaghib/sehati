<?php

namespace App\Http\Controllers;

use App\Models\Guru;
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

        $guru = $user->userable_type == 'App\Models\Guru' ? $user->userable : null;

        return view('dashboard.admin.guru.profile', compact('title', 'user', 'guru'));
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
