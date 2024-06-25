<?php

use App\Http\Controllers\BajuController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('home', function () {
        return view('admin.home')->with('showNavbar', true);
    })->name('home');

    Route::resource('user', UserController::class);

    /*----------------------------------------PENGGUNA--------------------------------------*/
    Route::resource('pengguna', PenggunaController::class);
    Route::post('profile/update', [PenggunaController::class, 'updateProfile'])->name('profile.update');
    Route::get('profile', [PenggunaController::class, 'profile'])->name('pengguna.profile');



    /*----------------------------------------BAJU--------------------------------------*/
    Route::resource('baju', BajuController::class);
    Route::post('/checkout', [BajuController::class, 'checkout'])->name('checkout');



    /*----------------------------------------TRANSAKSI--------------------------------------*/
    Route::resource('transaksi', TransaksiController::class);
    Route::get('/transaksi/ukuran/{nama_baju}', [TransaksiController::class, 'getUkuran']);
    Route::get('/transaksi/konfirmasi/{transaksi}', [TransaksiController::class, 'konfirmasi'])->name('transaksi.konfirmasi');
    Route::get('/transaksi/selesai/{transaksi}', [TransaksiController::class, 'tandaiSelesai'])->name('transaksi.selesai');
    Route::post('/transaksi/tambah-data-baju', [TransaksiController::class, 'tambahDataBaju'])->name('transaksi.tambahDataBaju');
    Route::get('/riwayat-penyewaan', [TransaksiController::class, 'riwayatPenyewaan'])->name('transaksi.riwayat');


    /*----------------------------------------DETAIL TRANSAKSI--------------------------------------*/
    Route::resource('detailTransaksi', DetailTransaksiController::class);


    /*----------------------------------------PEMBAYARAN--------------------------------------*/
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('/pembayaran/tandaiLunas/{pembayaran}', [PembayaranController::class, 'tandaiLunas'])->name('pembayaran.tandaiLunas');
    Route::put('/pembayaran/updatePembayaran/{pembayaran}', [PembayaranController::class, 'updatePembayaran'])->name('pembayaran.updatePembayaran');


    /*----------------------------------------PENGEMBALIAN--------------------------------------*/
    Route::resource('pengembalian', PengembalianController::class);
    Route::get('/pengembalian/tandaiKembali/{pengembalian}', [PengembalianController::class, 'tandaiKembali'])->name('pengembalian.tandaiKembali');
});
