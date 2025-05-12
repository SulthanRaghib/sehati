<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    public function tahunAkademik()
    {
        $title = 'Tahun Akademik';
        $tahunAkademik = TahunAkademik::orderByDesc('is_active')
            ->orderByDesc('periode')
            ->get();

        return view('dashboard.data_master.tahun_akademik.index', compact('title', 'tahunAkademik'));
    }

    public function create()
    {
        $title = 'Tambah Tahun Akademik';
        return view('dashboard.data_master.tahun_akademik.create', compact('title'));
    }

    public function store(Request $request)
    {
        // Validasi input sebelum menonaktifkan tahun akademik lama
        $request->validate([
            'periode' => [
                'required',
                'regex:/^\d{4}\/\d{4}$/',
                function ($attribute, $value, $fail) {
                    if (!str_contains($value, '/')) {
                        $fail('Format periode harus dalam bentuk YYYY/YYYY.');
                        return;
                    }

                    $tahun = explode('/', $value);

                    if (count($tahun) !== 2) {
                        $fail('Format periode harus dalam bentuk YYYY/YYYY.');
                        return;
                    }

                    [$tahunAwal, $tahunAkhir] = $tahun;

                    if ((int)$tahunAkhir !== (int)$tahunAwal + 1) {
                        $fail('Tahun kedua harus lebih besar 1 dari tahun pertama.');
                    }
                },
            ],
            'semester' => 'required|in:Ganjil,Genap',
        ], [
            'periode.regex' => 'Format periode harus dalam bentuk YYYY/YYYY.',
            'semester.in' => 'Semester harus Ganjil atau Genap.',
        ]);

        // Cek apakah tahun akademik sudah ada
        $tahunAkademikExist = TahunAkademik::where('periode', $request->periode)
            ->where('semester', $request->semester)
            ->first();
        if ($tahunAkademikExist) {
            return redirect()->back()->with('error', 'Tahun akademik sudah ada');
        }

        // Setelah validasi berhasil, baru nonaktifkan tahun akademik sebelumnya
        TahunAkademik::where('is_active', 1)->update(['is_active' => 0]);

        // Tambahkan tahun akademik baru dan set sebagai aktif
        $tahunAkademikBaru = TahunAkademik::create([
            'periode' => $request->periode,
            'semester' => $request->semester,
            'is_active' => 1,
        ]);

        // Pastikan siswa hanya diperbarui jika tabel siswa tidak kosong
        if (Siswa::exists()) {
            Siswa::whereNotNull('id')->update(['tahun_akademik_id' => $tahunAkademikBaru->id]);
        }

        return redirect()->route('admin.tahunAkademik')->with('success', 'Tahun akademik berhasil ditambahkan');
    }

    public function edit($id)
    {
        $title = 'Edit Tahun Akademik';
        $tahunAkademik = TahunAkademik::findOrFail($id);

        return view('dashboard.data_master.tahun_akademik.edit', compact('title', 'tahunAkademik'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'periode' => [
                'required',
                'regex:/^\d{4}\/\d{4}$/',
                function ($attribute, $value, $fail) {
                    if (!str_contains($value, '/')) {
                        $fail('Format periode harus dalam bentuk YYYY/YYYY.');
                        return;
                    }

                    $tahun = explode('/', $value);

                    if (count($tahun) !== 2) {
                        $fail('Format periode harus dalam bentuk YYYY/YYYY.');
                        return;
                    }

                    [$tahunAwal, $tahunAkhir] = $tahun;

                    if ((int)$tahunAkhir !== (int)$tahunAwal + 1) {
                        $fail('Tahun kedua harus lebih besar 1 dari tahun pertama.');
                    }
                },
            ],
            'semester' => 'required|in:Ganjil,Genap',
        ], [
            'periode.regex' => 'Format periode harus dalam bentuk YYYY/YYYY.',
            'semester.in' => 'Semester harus Ganjil atau Genap.',
        ]);

        // Cek apakah tahun akademik sudah ada
        $tahunAkademikExist = TahunAkademik::where('periode', $request->periode)
            ->where('semester', $request->semester)
            ->where('id', '<>', $id)
            ->first();
        if ($tahunAkademikExist) {
            return redirect()->back()->with('error', 'Tahun akademik sudah ada');
        }

        // Update tahun akademik
        TahunAkademik::where('id', $id)->update([
            'periode' => $request->periode,
            'semester' => $request->semester,
        ]);

        return redirect()->route('admin.tahunAkademik')->with('success', 'Tahun akademik berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tahun = TahunAkademik::findOrFail($id);
        if ($tahun->is_active) {
            return back()->with('error', 'Tahun akademik aktif tidak bisa dihapus.');
        }

        if ($tahun->siswa()->exists()) {
            return back()->with('error', 'Tahun akademik ini masih digunakan oleh siswa.');
        }

        $tahun->delete();

        return redirect()->route('admin.tahunAkademik')->with('success', 'Tahun akademik berhasil dihapus');
    }

    public function setTahunAkademik($id)
    {
        // Nonaktifkan semua tahun akademik
        TahunAkademik::where('is_active', 1)->update(['is_active' => 0]);

        // Set tahun akademik baru sebagai aktif
        TahunAkademik::where('id', $id)->update(['is_active' => 1]);

        // Perbarui tahun akademik siswa
        Siswa::whereNotNull('id')->update(['tahun_akademik_id' => $id]);

        return redirect()->route('admin.tahunAkademik')->with('success', 'Tahun akademik berhasil diatur');
    }
}
