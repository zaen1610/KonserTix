<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KategoriEventController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserHomeController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Guest
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class,'showLogin'])->name('login');
    Route::post('/login', [AuthController::class,'login'])->name('login.process');

    Route::get('/register',[AuthController::class,'showRegister'])->name('register');
    Route::post('/register',[AuthController::class,'register'])->name('register.process');

});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout',[AuthController::class,'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])->group(function(){

    Route::get('/',[DashboardController::class,'index'])
        ->name('dashboard');

    Route::resource('events',EventController::class);

    Route::resource('kategori',KategoriEventController::class);

    Route::resource('lokasi',LokasiController::class);

    Route::resource('tiket',TiketController::class);

    Route::resource('users',UserController::class);

    Route::resource('transaksi',TransaksiController::class);

    Route::patch(
        '/transaksi/{id}/konfirmasi',
        [TransaksiController::class,'konfirmasi']
    )->name('transaksi.konfirmasi');

    Route::get('/laporan',
        [LaporanController::class,'index']
    )->name('laporan.index');

    Route::get('/laporan/pdf',
        [LaporanController::class,'pdf']
    )->name('laporan.pdf');

});

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:user'])->group(function(){

    Route::get('/user-home',
        [UserHomeController::class,'index'])
        ->name('user.home');

    Route::get('/user-events',
        [UserHomeController::class,'event'])
        ->name('user.events');

    Route::get('/user-events/{id}',
        [EventController::class,'showUser'])
        ->name('user.event.show');

    // Halaman/konfirmasi pembelian tiket (GET)
    Route::get('/beli-tiket/{id}',
        [TransaksiController::class,'beli'])
        ->name('tiket.beli');

    // Proses pembelian tiket (POST)
    Route::post('/beli-tiket/{id}/process',
        [TransaksiController::class,'beliProcess'])
        ->name('tiket.beli.process');



    Route::get('/riwayat-pembelian',
        [UserHomeController::class,'riwayat'])
        ->name('user.riwayat');

});