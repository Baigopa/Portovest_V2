<?php

use Illuminate\Support\Facades\Route;

// ====================================================
// 1. HALAMAN PUBLIK (Landing Page & Auth)
// ====================================================

// Halaman Depan (Landing Page)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Halaman Login & Register (Hanya Tampilan)
// Diberi nama 'login' dan 'register' agar tombol di Landing Page berfungsi
Route::get('/login', function () { return view('login'); })->name('login');
Route::get('/register', function () { return view('register'); })->name('register');


// ====================================================
// 2. HALAMAN DASHBOARD (Aplikasi Utama)
// ====================================================

// Route ini mengarah ke tampilan dashboard
// Perlindungan (Cek Token) dilakukan oleh JavaScript di dalam file view-nya
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
