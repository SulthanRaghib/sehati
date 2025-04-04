<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgamaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\PendidikanTerakhirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/home', [SiswaController::class, 'home'])->name('siswa.home');
});

Route::middleware(['auth', 'role:admin,gurubk'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    Route::get('/guru', [AdminController::class, 'guru'])->name('admin.guru');
    Route::get('/guru/create', [AdminController::class, 'createGuru'])->name('admin.guru.create');
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
});

require __DIR__ . '/auth.php';
