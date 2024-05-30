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

    Route::get('profile', function () {
        return view('auth.profile');
    })->name('profile');

    Route::resource('user', UserController::class);
    Route::resource('pengguna', PenggunaController::class);
});
