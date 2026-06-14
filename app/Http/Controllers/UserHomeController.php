<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaksi;

class UserHomeController extends Controller
{
    public function index()
    {
        $events = Event::with([
            'kategori',
            'lokasi',
            'tikets'
        ])->latest()->take(6)->get();

        return view('user.home', compact('events'));
    }

    public function event()
    {
        $events = Event::with([
            'kategori',
            'lokasi',
            'tikets'
        ])->latest()->paginate(9);

        return view('user.event', compact('events'));
    }

    public function riwayat()
    {
        $transaksis = Transaksi::with([
            'tiket.event'
        ])
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(10);

        return view('user.riwayat', compact('transaksis'));
    }
}