<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaksi;

class UserHomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Halaman utama user — tampil 6 event terbaru
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $events = Event::with(['kategori', 'lokasi'])
            ->latest()
            ->take(6)
            ->get();

        return view('user.home', compact('events'));
    }

    /*
    |--------------------------------------------------------------------------
    | Semua event (untuk halaman "Jelajahi Event")
    |--------------------------------------------------------------------------
    */
    public function event()
    {
        $events = Event::with(['kategori', 'lokasi'])
            ->latest()
            ->get();

        return view('user.event', compact('events'));
    }

    /*
    |--------------------------------------------------------------------------
    | ★ Riwayat pembelian milik user yang sedang login
    |--------------------------------------------------------------------------
    */
    public function riwayat()
    {
        $transaksis = Transaksi::with('tiket.event')
            ->where('user_id', auth()->id())   // ★ filter punya user sendiri
            ->latest()
            ->paginate(10);

        return view('user.riwayat', compact('transaksis'));
    }
}