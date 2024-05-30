<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('home', function () {
    //     return view('admin.home');
    // })->name('home');

    Route::get('profile', function () {
        return view('auth.profile');
    })->name('profile');

    Route::resource('user', UserController::class);
});
