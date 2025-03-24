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
Route::get('/testing/dashboard', [HomeController::class, 'testingDashboard'])->name('testing.dashboard');
Route::get('/testing/user', [HomeController::class, 'testingUser'])->name('testing.user');

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

Route::middleware(['auth', 'role:gurubk'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    Route::get('/admin/guru', [AdminController::class, 'guru'])->name('admin.guru');
    Route::get('/admin/guru/create', [AdminController::class, 'createGuru'])->name('admin.guru.create');
    Route::get('/admin/guru/{id}', [AdminController::class, 'showGuru'])->name('admin.guru.show');
    Route::post('/admin/guru', [AdminController::class, 'storeGuru'])->name('admin.guru.store');
    Route::get('/admin/guru/{id}/edit', [AdminController::class, 'editGuru'])->name('admin.guru.edit');
    Route::put('/admin/guru/{id}', [AdminController::class, 'updateGuru'])->name('admin.guru.update');
    Route::delete('/admin/guru/{id}', [AdminController::class, 'destroyGuru'])->name('admin.guru.destroy');

    Route::get('/admin/siswa', [AdminController::class, 'siswa'])->name('admin.siswa');
    Route::get('/admin/siswa/create', [AdminController::class, 'createSiswa'])->name('admin.siswa.create');
    Route::get('/admin/siswa/{id}', [AdminController::class, 'showSiswa'])->name('admin.siswa.show');
    Route::post('/admin/siswa', [AdminController::class, 'storeSiswa'])->name('admin.siswa.store');
    Route::get('/admin/siswa/{id}/edit', [AdminController::class, 'editSiswa'])->name('admin.siswa.edit');
    Route::put('/admin/siswa/{id}', [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/{id}', [AdminController::class, 'destroySiswa'])->name('admin.siswa.destroy');

    // Data Master
    Route::get('/admin/agama', [AgamaController::class, 'index'])->name('admin.agama');
    Route::get('/admin/agama/create', [AgamaController::class, 'create'])->name('admin.agama.create');
    Route::post('/admin/agama', [AgamaController::class, 'store'])->name('admin.agama.store');
    Route::get('/admin/agama/{id}/edit', [AgamaController::class, 'edit'])->name('admin.agama.edit');
    Route::put('/admin/agama/{id}', [AgamaController::class, 'update'])->name('admin.agama.update');
    Route::delete('/admin/agama/{id}', [AgamaController::class, 'destroy'])->name('admin.agama.destroy');

    Route::get('/admin/kelas', [KelasController::class, 'index'])->name('admin.kelas');
    Route::get('/admin/kelas/create', [KelasController::class, 'create'])->name('admin.kelas.create');
    Route::post('/admin/kelas', [KelasController::class, 'store'])->name('admin.kelas.store');
    Route::get('/admin/kelas/{id}/edit', [KelasController::class, 'edit'])->name('admin.kelas.edit');
    Route::put('/admin/kelas/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
    Route::delete('/admin/kelas/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');

    Route::get('/admin/pendidikan-terakhir', [PendidikanTerakhirController::class, 'index'])->name('admin.pendidikanTerakhir');
    Route::get('/admin/pendidikan-terakhir/create', [PendidikanTerakhirController::class, 'create'])->name('admin.pendidikanTerakhir.create');
    Route::post('/admin/pendidikan-terakhir', [PendidikanTerakhirController::class, 'store'])->name('admin.pendidikanTerakhir.store');
    Route::get('/admin/pendidikan-terakhir/{id}/edit', [PendidikanTerakhirController::class, 'edit'])->name('admin.pendidikanTerakhir.edit');
    Route::put('/admin/pendidikan-terakhir/{id}', [PendidikanTerakhirController::class, 'update'])->name('admin.pendidikanTerakhir.update');
    Route::delete('/admin/pendidikan-terakhir/{id}', [PendidikanTerakhirController::class, 'destroy'])->name('admin.pendidikanTerakhir.destroy');

    Route::get('/admin/pekerjaan', [PekerjaanController::class, 'index'])->name('admin.pekerjaan');
    Route::get('/admin/pekerjaan/create', [PekerjaanController::class, 'create'])->name('admin.pekerjaan.create');
    Route::post('/admin/pekerjaan', [PekerjaanController::class, 'store'])->name('admin.pekerjaan.store');
    Route::get('/admin/pekerjaan/{id}/edit', [PekerjaanController::class, 'edit'])->name('admin.pekerjaan.edit');
    Route::put('/admin/pekerjaan/{id}', [PekerjaanController::class, 'update'])->name('admin.pekerjaan.update');
    Route::delete('/admin/pekerjaan/{id}', [PekerjaanController::class, 'destroy'])->name('admin.pekerjaan.destroy');
});

require __DIR__ . '/auth.php';
