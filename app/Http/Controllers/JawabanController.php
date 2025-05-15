<?php

namespace App\Http\Controllers;

use App\Events\NewJawaban;
use App\Models\Jawaban;
use App\Models\Konseling;
use App\Models\Notifikasi;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JawabanController extends Controller
{
    public function adminReply(Request $request)
    {
        $user = Auth::user();
        $guruID = $user->userable_type === 'App\Models\Guru' ? $user->userable->id : null;
        $getKonselingID = Konseling::findOrFail($request->konseling_id);
        // Ambil siswa_id dari relasi
        $siswaId = $getKonselingID->siswa_id;

        $request->validate(
            [
                'isi_jawaban' => 'required',
            ],
            [
                'isi_jawaban.required' => 'Jawaban tidak boleh kosong.',
            ]
        );

        // Insert jawaban dulu
        $jawaban = Jawaban::create([
            'konseling_id' => $request->konseling_id,
            'isi_jawaban' => $request->isi_jawaban,
            'guru_id' => $guruID,
            'tanggal_jawaban' => now(),
        ]);

        $notifikasi = Notifikasi::create([
            'user_id' => $siswaId,
            'title' => 'Jawaban Konseling',
            'type' => 'jawaban',
            'body' => $request->isi_jawaban,
            'related_id' => $jawaban->id,
            'related_type' => Jawaban::class,
        ]);
        event(new NewJawaban($notifikasi));

        // Update notifikasi konseling terkait jadi terbaca
        Notifikasi::where('is_read', false)
            ->where('related_type', Konseling::class)
            ->where('related_id', $request->konseling_id)
            ->update(['is_read' => true]);


        // Update status konseling
        $getKonselingID->update([
            'status_id' => 2,
        ]);

        return redirect()->route('admin.konseling')->with('success', 'Jawaban berhasil dikirim');
    }

    public function siswaJawabanUnread()
    {
        $title = 'Jawaban Konseling';
        $siswaID = Auth::user()->userable->id;

        $notifikasi = Notifikasi::where('user_id', $siswaID)
            ->where('is_read', false)
            ->where('type', 'jawaban')
            ->whereHasMorph('related', [\App\Models\Jawaban::class], function ($query) use ($siswaID) {
                $query->whereHas('konseling', function ($konselingQuery) use ($siswaID) {
                    $konselingQuery->where('siswa_id', $siswaID);
                })
                    ->whereDoesntHave('ratings', function ($ratingQuery) use ($siswaID) {
                        $ratingQuery->where('siswa_id', $siswaID);
                    });
            })
            ->with('related') // pastikan load Jawaban
            ->latest()
            ->get();

        return view('frontend.konseling.jawaban', compact('title', 'notifikasi'));
    }

    public function rating(Request $request)
    {
        $request->validate(
            [
                'jawaban_id' => 'required|exists:jawabans,id',
                'rating' => 'required|integer|min:1|max:5',
                'komentar' => 'nullable|string',
            ],
            [
                'jawaban_id.required' => 'Jawaban tidak boleh kosong.',
                'jawaban_id.exists' => 'Jawaban tidak ditemukan.',
                'rating.required' => 'Rating tidak boleh kosong.',
                'rating.integer' => 'Rating harus berupa angka.',
                'rating.min' => 'Rating minimal 1.',
                'rating.max' => 'Rating maksimal 5.',
                'komentar.string' => 'Komentar harus berupa teks.',
            ]
        );

        $siswaId = Auth::user()->userable->id;

        Rating::create([
            'jawaban_id' => $request->jawaban_id,
            'siswa_id' => $siswaId,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        $jawaban = Jawaban::with('konseling')->find($request->jawaban_id);
        if ($jawaban && $jawaban->konseling) {
            $jawaban->konseling->update([
                'status_id' => 3,
            ]);
        }

        // Update notifikasi terkait jadi terbaca
        Notifikasi::where('is_read', false)
            ->where('related_type', Jawaban::class)
            ->where('related_id', $request->jawaban_id)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Rating berhasil diberikan');
    }

    public function adminBalas($id)
    {
        $title = 'Balas Konseling';
        $konseling = Konseling::findOrFail($id);

        return view('dashboard.konseling.balas', compact('title', 'konseling'));
    }
}
