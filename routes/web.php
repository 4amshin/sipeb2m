<?php

use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('home', function () {
        return view('admin.home');
    })->name('home');

    Route::resource('user', UserController::class);

    Route::resource('pengguna', PenggunaController::class);
    Route::get('profile', [PenggunaController::class, 'profile'])->name('pengguna.profile');
});
