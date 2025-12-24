<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController; // <--- JANGAN LUPA INI

// ==========================================
// 1. ZONA PUBLIC (Boleh Masuk Tanpa Token)
// ==========================================

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Asset (Hanya BACA)
Route::get('/assets', [AssetController::class, 'index']);
// UBAH: {id} jadi {uuid} agar sesuai controller
Route::get('/assets/{uuid}', [AssetController::class, 'show']);


// ==========================================
// 2. ZONA PROTECTED (WAJIB Token / Login)
// ==========================================

Route::middleware('auth:api')->group(function () {

    // Auth
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Asset (CRUD)
    Route::post('/assets', [AssetController::class, 'store']);
    // UBAH: {id} jadi {uuid}
    Route::post('/assets/{uuid}', [AssetController::class, 'update']);
    Route::delete('/assets/{uuid}', [AssetController::class, 'destroy']);

    // --- FITUR BARU: TRANSAKSI (JUAL/BELI) ---
    // Route ini otomatis mengurangi/menambah stok
    Route::post('/transactions', [TransactionController::class, 'store']);

});
