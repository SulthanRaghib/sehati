<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GurubkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/home', [SiswaController::class, 'home'])->name('siswa.home');
});

Route::middleware(['auth', 'role:gurubk'])->group(function () {
    Route::get('/gurubk/dashboard', [GurubkController::class, 'dashboard'])->name('dashboard.index');
});

require __DIR__ . '/auth.php';
