<?php

use App\Http\Controllers\Api\ApiKonselingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/konseling', [ApiKonselingController::class, 'index']);
Route::post('/konseling', [ApiKonselingController::class, 'store']);
