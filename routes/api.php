<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\TransactionController;

// =========================================================================
// 1. PUBLIC ROUTES (Pintu Gerbang - Tanpa Token)
// =========================================================================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// =========================================================================
// 2. PROTECTED ROUTES (Area Member - Wajib Token)
// =========================================================================
Route::middleware('auth:sanctum')->group(function () {

    // TAMBAHKAN INI:
    Route::get('/assets/live-prices', [AssetController::class, 'getLivePrices']);

    // Cek User Profile
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- MANAJEMEN ASET (CRUD) ---
    // Menggunakan POST untuk update {id} agar upload gambar (logo) lebih stabil
    Route::get('/assets', [AssetController::class, 'index']);
    Route::post('/assets', [AssetController::class, 'store']);
    Route::get('/assets/{id}', [AssetController::class, 'show']);
    Route::post('/assets/{id}', [AssetController::class, 'update']);
    Route::delete('/assets/{id}', [AssetController::class, 'destroy']);

    // --- TRANSAKSI ---
    Route::post('/transactions', [TransactionController::class, 'store']);
});
