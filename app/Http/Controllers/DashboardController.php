<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();

        $totalEvents = Event::count();

        $totalTiketTerjual = Transaksi::sum('jumlah') ?? 0;

        $totalPendapatan = Transaksi::sum('total_harga') ?? 0;

        $recentTransaksi = Transaksi::with('tiket.event')
            ->latest()
            ->take(5)
            ->get();

        $upcomingEvents = Event::with([
            'lokasi',
            'kategori',
            'tikets'
        ])
        ->latest()
        ->take(5)
        ->get();

        return view('dashboard', compact(
            'totalUsers',
            'totalEvents',
            'totalTiketTerjual',
            'totalPendapatan',
            'recentTransaksi',
            'upcomingEvents'
        ));
    }
}