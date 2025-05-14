<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgamaController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\ArtikelKategoriController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KonselingController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\PendidikanTerakhirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAkademik;
use App\Http\Controllers\TahunAkademikController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Stichoza\GoogleTranslate\GoogleTranslate;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/quote', function () {
    $response = Http::get('https://favqs.com/api/qotd');
    $data = $response->json();

    $quote = $data['quote']['body'] ?? '';
    $author = $data['quote']['author'] ?? 'Unknown';

    // Translate ke Bahasa Indonesia
    $tr = new GoogleTranslate('id');
    $translated = $tr->translate($quote);

    return response()->json([
        'original' => $quote,
        'translated' => $translated,
        'author' => $author,
    ]);
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Artikel`
Route::get('/artikels', [HomeController::class, 'artikelSiswa'])->name('siswa.artikel');
Route::get('/detail-artikel/{slug}', [ArtikelController::class, 'viewArtikel'])->name('siswa.artikel.show');

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa-konseling', [KonselingController::class, 'siswaKonseling'])->name('siswa.konseling');
    Route::post('/siswa-konseling/store', [KonselingController::class, 'siswaKonselingStore'])->name('siswa.konselingStore');
    Route::get('/siswa-konseling/history', [KonselingController::class, 'siswaKonselingRiwayat'])->name('siswa.konselingRiwayat');
    Route::get('/siswa-konseling/jawaban-unread', [JawabanController::class, 'siswaJawabanUnread'])->name('siswa.konselingJawabanUnread');
    Route::put('/siswa-konseling/update/{id}', [KonselingController::class, 'siswaUpdateKonseling'])->name('siswa.konselingUpdate');
    Route::delete('/siswa-konseling/{id}', [KonselingController::class, 'siswaKonselingDestroy'])->name('siswa.konseling.destroy');

    Route::get('/notifikasi/fetch/jawaban', [NotifikasiController::class, 'fetchNotifikasiJawaban']);
    Route::post('/notifikasi/baca/jawaban', [NotifikasiController::class, 'tandaiSudahDibacaJawaban']);
    Route::post('/notifikasi/{id}/read/jawaban', [NotifikasiController::class, 'tandaiDibacaJawaban'])->name('notifikasi.markAsRead');
    Route::post('/jawaban/rating', [JawabanController::class, 'rating'])->name('jawaban.rating');

    Route::get('/siswa/profile', [SiswaController::class, 'profile'])->name('siswa.profile.show');
    Route::get('/siswa/profile/edit', [SiswaController::class, 'editProfile'])->name('siswa.profile.edit');
    Route::put('/siswa/profile/update', [SiswaController::class, 'updateDataSiswa'])->name('siswa.profile.update');
    Route::post('/upload/foto/siswa', [SiswaController::class, 'uploadFoto'])->name('siswa.upload.foto');
    Route::get('/siswa/profile/new-password', [SiswaController::class, 'editPassword'])->name('siswa.profile.newPassword');
    Route::put('/siswa/profile/new-password', [SiswaController::class, 'updatePassword'])->name('siswa.profile.newPassword.update');

    Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
});

Route::middleware(['auth', 'role:admin,gurubk'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Data Sekolah
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::get('/users/{id}/edit-password', [AdminController::class, 'editUserPassword'])->name('admin.users.password.edit');
    Route::put('/users/{id}/update-password', [AdminController::class, 'updateUserPassword'])->name('admin.users.password.update');

    Route::get('/guru', [AdminController::class, 'guru'])->name('admin.guru');
    Route::get('/guru/create', [AdminController::class, 'createGuru'])->name('admin.guru.create');
    Route::get('/guru/profile', [GuruController::class, 'profileGuru'])->name('admin.guru.profile');
    Route::post('/upload/foto/guru', [GuruController::class, 'uploadFoto'])->name('guru.upload.foto');
    Route::get('/guru/{id}', [AdminController::class, 'showGuru'])->name('admin.guru.show');
    Route::post('/guru', [AdminController::class, 'storeGuru'])->name('admin.guru.store');
    Route::get('/guru/{id}/edit', [AdminController::class, 'editGuru'])->name('admin.guru.edit');
    Route::put('/guru/{id}', [AdminController::class, 'updateGuru'])->name('admin.guru.update');
    Route::delete('/guru/{id}', [AdminController::class, 'destroyGuru'])->name('admin.guru.destroy');

    Route::get('/siswa', [AdminController::class, 'siswa'])->name('admin.siswa');
    Route::get('/siswa/create', [AdminController::class, 'createSiswa'])->name('admin.siswa.create');
    Route::get('/siswa/{id}', [AdminController::class, 'showSiswa'])->name('admin.siswa.show');
    Route::post('/siswa', [AdminController::class, 'storeSiswa'])->name('admin.siswa.store');
    Route::get('/siswa/{id}/edit', [AdminController::class, 'editSiswa'])->name('admin.siswa.edit');
    Route::put('/siswa/{id}', [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');
    Route::delete('/siswa/{id}', [AdminController::class, 'destroySiswa'])->name('admin.siswa.destroy');

    Route::get('/tahun-akademik', [TahunAkademikController::class, 'tahunAkademik'])->name('admin.tahunAkademik');
    Route::get('/tahun-akademik/create', [TahunAkademikController::class, 'create'])->name('admin.tahunAkademik.create');
    Route::post('/tahun-akademik', [TahunAkademikController::class, 'store'])->name('admin.tahunAkademik.store');
    Route::post('/tahun-akademik/set/{id}', [TahunAkademikController::class, 'setTahunAkademik'])->name('admin.setTahunAkademik');
    Route::get('/tahun-akademik/{id}/edit', [TahunAkademikController::class, 'edit'])->name('admin.tahunAkademik.edit');
    Route::put('/tahun-akademik/{id}', [TahunAkademikController::class, 'update'])->name('admin.tahunAkademik.update');
    Route::delete('/tahun-akademik/{id}', [TahunAkademikController::class, 'destroy'])->name('admin.tahunAkademik.destroy');

    // Data Master
    Route::get('/agama', [AgamaController::class, 'index'])->name('admin.agama');
    Route::get('/agama/create', [AgamaController::class, 'create'])->name('admin.agama.create');
    Route::post('/agama', [AgamaController::class, 'store'])->name('admin.agama.store');
    Route::get('/agama/{id}/edit', [AgamaController::class, 'edit'])->name('admin.agama.edit');
    Route::put('/agama/{id}', [AgamaController::class, 'update'])->name('admin.agama.update');
    Route::delete('/agama/{id}', [AgamaController::class, 'destroy'])->name('admin.agama.destroy');

    Route::get('/kelas', [KelasController::class, 'index'])->name('admin.kelas');
    Route::get('/kelas/create', [KelasController::class, 'create'])->name('admin.kelas.create');
    Route::post('/kelas', [KelasController::class, 'store'])->name('admin.kelas.store');
    Route::get('/kelas/{id}/edit', [KelasController::class, 'edit'])->name('admin.kelas.edit');
    Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');

    Route::get('/pendidikan-terakhir', [PendidikanTerakhirController::class, 'index'])->name('admin.pendidikanTerakhir');
    Route::get('/pendidikan-terakhir/create', [PendidikanTerakhirController::class, 'create'])->name('admin.pendidikanTerakhir.create');
    Route::post('/pendidikan-terakhir', [PendidikanTerakhirController::class, 'store'])->name('admin.pendidikanTerakhir.store');
    Route::get('/pendidikan-terakhir/{id}/edit', [PendidikanTerakhirController::class, 'edit'])->name('admin.pendidikanTerakhir.edit');
    Route::put('/pendidikan-terakhir/{id}', [PendidikanTerakhirController::class, 'update'])->name('admin.pendidikanTerakhir.update');
    Route::delete('/pendidikan-terakhir/{id}', [PendidikanTerakhirController::class, 'destroy'])->name('admin.pendidikanTerakhir.destroy');

    Route::get('/pekerjaan', [PekerjaanController::class, 'index'])->name('admin.pekerjaan');
    Route::get('/pekerjaan/create', [PekerjaanController::class, 'create'])->name('admin.pekerjaan.create');
    Route::post('/pekerjaan', [PekerjaanController::class, 'store'])->name('admin.pekerjaan.store');
    Route::get('/pekerjaan/{id}/edit', [PekerjaanController::class, 'edit'])->name('admin.pekerjaan.edit');
    Route::put('/pekerjaan/{id}', [PekerjaanController::class, 'update'])->name('admin.pekerjaan.update');
    Route::delete('/pekerjaan/{id}', [PekerjaanController::class, 'destroy'])->name('admin.pekerjaan.destroy');

    Route::get('/artikel-kategori', [ArtikelKategoriController::class, 'index'])->name('admin.artikelKategori');
    Route::get('/artikel-kategori/create', [ArtikelKategoriController::class, 'create'])->name('admin.artikelKategori.create');
    Route::post('/artikel-kategori', [ArtikelKategoriController::class, 'store'])->name('admin.artikelKategori.store');
    Route::get('/artikel-kategori/{id}/edit', [ArtikelKategoriController::class, 'edit'])->name('admin.artikelKategori.edit');
    Route::put('/artikel-kategori/{id}', [ArtikelKategoriController::class, 'update'])->name('admin.artikelKategori.update');
    Route::delete('/artikel-kategori/{id}', [ArtikelKategoriController::class, 'destroy'])->name('admin.artikelKategori.destroy');

    // Bimbingan Konseling
    Route::get('/konseling', [KonselingController::class, 'adminIndex'])->name('admin.konseling');
    Route::get('/konseling/{id}/balas-konseling', [JawabanController::class, 'adminBalas'])->name('admin.konseling.balas');
    Route::post('/konseling/reply', [JawabanController::class, 'adminReply'])->name('admin.konseling.reply');
    Route::get('/konseling/create', [KonselingController::class, 'adminCreate'])->name('admin.konseling.create');
    Route::post('/konseling', [KonselingController::class, 'adminStore'])->name('admin.konseling.store');
    Route::get('/konseling/{id}/edit-jawaban', [KonselingController::class, 'adminEdit'])->name('admin.konseling.edit');
    Route::put('/konseling/{id}/update', [KonselingController::class, 'adminUpdate'])->name('admin.konseling.update');
    Route::get('/konseling/{id}/show', [KonselingController::class, 'adminShow'])->name('admin.konseling.show');
    Route::delete('/konseling/{id}', [KonselingController::class, 'adminDestroy'])->name('admin.konseling.destroy');
    Route::post('/siswa-konseling', [KonselingController::class, 'siswaKonseling'])->name('siswa.konseling.store');

    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel');
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
    Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');
    Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');
    Route::post('/artikel/{id}/publish', [ArtikelController::class, 'publish'])->name('artikel.publish');
    Route::post('/artikel/{id}/draft', [ArtikelController::class, 'draft'])->name('artikel.draft');

    Route::get('/konseling-siswa/{id}/detail', [KonselingController::class, 'siswaDetail'])->name('admin.siswa.detailKonseling');

    // Notifikasi
    Route::get('/notifikasi/fetch/konseling', [NotifikasiController::class, 'fetchNotifikasiKonseling']);
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'tandaiDibacaKonseling']);
    Route::post('/notifikasi/baca/konseling', [NotifikasiController::class, 'tandaiSudahDibacaKonseling']);
});

require __DIR__ . '/auth.php';
