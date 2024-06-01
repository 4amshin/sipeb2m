<?php

use App\Http\Controllers\BajuController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TransaksiController;
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

    Route::resource('baju', BajuController::class);

    Route::resource('transaksi', TransaksiController::class);
    Route::get('/transaksi/ukuran/{nama_baju}', [TransaksiController::class, 'getUkuran']);

    Route::resource('detailTransaksi', DetailTransaksiController::class);
});
