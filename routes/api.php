<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DokuWebhookController;
use App\Http\Controllers\backend\NilaiController; //

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/kelas/{kelas_id}/siswa', [NilaiController::class, 'getSiswaByKelas'])->middleware('auth:sanctum');

// DOKU Webhook Notification Route yang ditambahkan untuk menerima notifikasi pembayaran
// "api/doku/notification"
Route::post('/doku/notification', [DokuWebhookController::class, 'handle']);

