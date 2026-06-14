<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Tiket;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /*
    |==========================================================================
    | ADMIN: Lihat semua transaksi
    |==========================================================================
    */
    public function index()
    {
        $transaksis = Transaksi::with('tiket.event', 'user')
            ->latest()
            ->paginate(10);

        return view('transaksi.index', compact('transaksis'));
    }

    /*
    |==========================================================================
    | ADMIN: Form buat transaksi manual
    |==========================================================================
    */
    public function create()
    {
        $tikets = Tiket::all();
        return view('transaksi.create', compact('tikets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tiket_id'      => 'required',
            'nama_pembeli'  => 'required',
            'jumlah'        => 'required|numeric|min:1',
            'status'        => 'required'
        ]);

        $tiket = Tiket::findOrFail($request->tiket_id);

        if ($tiket->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak cukup');
        }

        $total = $tiket->harga * $request->jumlah;

        Transaksi::create([
            'tiket_id'      => $tiket->id,
            'nama_pembeli'  => $request->nama_pembeli,
            'jumlah'        => $request->jumlah,
            'total_harga'   => $total,
            'status'        => $request->status
        ]);

        $tiket->decrement('stok', $request->jumlah);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('tiket.event', 'user')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $tikets    = Tiket::all();
        return view('transaksi.edit', compact('transaksi', 'tikets'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'tiket_id'      => 'required',
            'nama_pembeli'  => 'required',
            'jumlah'        => 'required|numeric|min:1',
            'total_harga'   => 'required|numeric',
            'status'        => 'required'
        ]);

        $transaksi->update([
            'tiket_id'      => $request->tiket_id,
            'nama_pembeli'  => $request->nama_pembeli,
            'jumlah'        => $request->jumlah,
            'total_harga'   => $request->total_harga,
            'status'        => $request->status,
        ]);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        Transaksi::findOrFail($id)->delete();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }

    /*
    |==========================================================================
    | ★ ADMIN: Konfirmasi status transaksi (pending → confirmed / rejected)
    |==========================================================================
    */
    public function konfirmasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Confirmed,Rejected'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update(['status' => $request->status]);

        $pesan = $request->status === 'Confirmed'
            ? 'Transaksi berhasil dikonfirmasi!'
            : 'Transaksi berhasil ditolak.';

        return redirect()
            ->route('transaksi.index')
            ->with('success', $pesan);
    }

    /*
    |==========================================================================
    | ★ USER: Beli tiket → status otomatis 'Pending'
    |==========================================================================
    */
    public function beli($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $tiket = Tiket::findOrFail($id);

        if ($tiket->stok <= 0) {
            return back()->with('error', 'Stok tiket habis');
        }

        $jumlah = 1;
        $total  = $tiket->harga * $jumlah;

        Transaksi::create([
            'tiket_id'      => $tiket->id,
            'user_id'       => auth()->id(),
            'nama_pembeli'  => auth()->user()->name,
            'jumlah'        => $jumlah,
            'total_harga'   => $total,
            'status'        => 'Pending',   // ★ selalu pending dulu
        ]);

        $tiket->decrement('stok', $jumlah);

        return redirect()
            ->route('user.riwayat')
            ->with('success', 'Tiket berhasil dibeli! Menunggu konfirmasi admin.');
    }
}