<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriEventController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserHomeController;

/*
|--------------------------------------------------------------------------
| GUEST ROUTES (hanya bisa diakses jika belum login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.process');
});

/*
|--------------------------------------------------------------------------
| LOGOUT (semua user yang login bisa logout)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (hanya role 'admin')
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Event
    Route::resource('events', EventController::class);

    // Manajemen Tiket
    Route::resource('tiket', TiketController::class);

    // Transaksi Admin (lihat semua + konfirmasi status)
    Route::get('/transaksi',            [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create',     [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi',           [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}',       [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{id}/edit',  [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{id}',       [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{id}',    [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

    // ★ Konfirmasi status transaksi (pending → confirmed/rejected)
    Route::patch('/transaksi/{id}/konfirmasi', [TransaksiController::class, 'konfirmasi'])
         ->name('transaksi.konfirmasi');

    // Manajemen Kategori, Lokasi, User
    Route::resource('kategori', KategoriEventController::class);
    Route::resource('lokasi',   LokasiController::class);
    Route::resource('users',    UserController::class);

    // Laporan
    Route::get('/laporan',     [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'pdf'])->name('laporan.pdf');
});

/*
|--------------------------------------------------------------------------
| USER ROUTES (hanya role 'user')
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {

    // Halaman utama user
    Route::get('/user-home',      [UserHomeController::class, 'index'])->name('user.home');

    // Lihat daftar event
    Route::get('/user-events',    [UserHomeController::class, 'event'])->name('user.events');

    // ★ Riwayat pembelian user (hanya milik user ini)
    Route::get('/riwayat-pembelian', [UserHomeController::class, 'riwayat'])->name('user.riwayat');

    // ★ Beli tiket (POST) → status otomatis 'pending'
    Route::post('/beli-tiket/{id}', [TransaksiController::class, 'beli'])->name('tiket.beli');

    // Lihat detail event (read-only)
    Route::get('/events/{id}',    [EventController::class, 'showUser'])->name('user.event.show');
});