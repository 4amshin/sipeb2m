<?php

use App\Http\Controllers\BajuController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*----------------------------------------LANDING PAGE--------------------------------------*/
Route::get('/', function () {
    return view('landing-page.index');
});

Route::get('/product', [BajuController::class, 'koleksiBaju']);

Route::get('/contact', function () {
    return view('landing-page.contact');
});


/*----------------------------------------AUTH USER--------------------------------------*/
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
    Route::get('/check-stock/{baju}', [BajuController::class, 'checkStock']);


    /*----------------------------------------TRANSAKSI--------------------------------------*/
    Route::resource('transaksi', TransaksiController::class);
    Route::get('/transaksi/ukuran/{nama_baju}', [TransaksiController::class, 'getUkuran']);
    Route::post('/transaksi/tambah-data-baju', [TransaksiController::class, 'tambahDataBaju'])->name('transaksi.tambahDataBaju');

    /*----------------------------------------ORDERAN--------------------------------------*/
    Route::get('/daftarOrderan', [TransaksiController::class, 'daftarOrderan'])->name('daftarOrderan');
    Route::get('/transaksi/terimaOrderan/{transaksi}', [TransaksiController::class, 'terimaOrderan'])->name('transaksi.terimaOrderan');
    Route::get('/transaksi/tolakOrderan/{transaksi}', [TransaksiController::class, 'tolakOrderan'])->name('transaksi.tolakOrderan');

    /*----------------------------------------PENYEWAAAN--------------------------------------*/
    Route::get('/transaksi/diAmbil/{transaksi}', [TransaksiController::class, 'diAmbil'])->name('transaksi.diAmbil');
    Route::get('/transaksi/diKirim/{transaksi}', [TransaksiController::class, 'diKirim'])->name('transaksi.diKirim');

    /*----------------------------------------RIWAYAT--------------------------------------*/
    Route::get('/riwayat-penyewaan', [TransaksiController::class, 'riwayatPenyewaan'])->name('transaksi.riwayat');


    /*----------------------------------------DETAIL TRANSAKSI--------------------------------------*/
    Route::resource('detailTransaksi', DetailTransaksiController::class);


    /*----------------------------------------PEMBAYARAN--------------------------------------*/
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('/pembayaran/tandaiLunas/{pembayaran}', [PembayaranController::class, 'tandaiLunas'])->name('pembayaran.tandaiLunas');


    /*----------------------------------------PENGEMBALIAN--------------------------------------*/
    Route::resource('pengembalian', PengembalianController::class);
    Route::get('/pengembalian/tandaiKembali/{pengembalian}', [PengembalianController::class, 'tandaiKembali'])->name('pengembalian.tandaiKembali');
});
