<?php

use App\Http\Controllers\Api\ApiKonselingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Stichoza\GoogleTranslate\GoogleTranslate;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/konseling', [ApiKonselingController::class, 'index']);
Route::post('/konseling', [ApiKonselingController::class, 'store']);

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
