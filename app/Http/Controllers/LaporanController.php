<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function index()
    {
        $totalPendapatan =
            Transaksi::sum('total_harga');

        $totalTiket =
            Transaksi::sum('jumlah');

        $transaksis =
            Transaksi::with('tiket.event')
            ->latest()
            ->get();

        return view(
            'laporan.index',
            compact(
                'totalPendapatan',
                'totalTiket',
                'transaksis'
            )
        );
    }

    public function pdf()
    {
        $transaksis =
            Transaksi::with('tiket.event')
            ->get();

        $totalPendapatan =
            Transaksi::sum('total_harga');

        $totalTiket =
            Transaksi::sum('jumlah');

        $pdf =
            \Barryvdh\DomPDF\Facade\Pdf::loadView(
                'laporan.pdf',
                compact(
                    'transaksis',
                    'totalPendapatan',
                    'totalTiket'
                )
            );

        return $pdf->download(
            'laporan-penjualan.pdf'
        );
    }
}