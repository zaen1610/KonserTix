<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN - Semua Transaksi
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $transaksis = Transaksi::with([
            'user',
            'tiket.event'
        ])->latest()->paginate(10);

        return view('transaksi.index', compact('transaksis'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - Form Tambah
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $tikets = Tiket::with('event')->get();

        return view('transaksi.create', compact('tikets'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - Simpan
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'tiket_id' => 'required|exists:tikets,id',

            'nama_pembeli' => 'required',

            'jumlah' => 'required|integer|min:1',

            'status' => 'required'

        ]);

        DB::beginTransaction();

        try {

            $tiket = Tiket::findOrFail($request->tiket_id);

            if ($tiket->stok < $request->jumlah) {

                return back()->with(
                    'error',
                    'Stok tiket tidak mencukupi.'
                );

            }

            $total = $tiket->harga * $request->jumlah;

            Transaksi::create([

                'user_id' => auth()->id(),

                'tiket_id' => $tiket->id,

                'nama_pembeli' => $request->nama_pembeli,

                'jumlah' => $request->jumlah,

                'total_harga' => $total,

                'status' => $request->status

            ]);

            $tiket->decrement('stok', $request->jumlah);

            DB::commit();

            return redirect()
                ->route('transaksi.index')
                ->with('success', 'Transaksi berhasil.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );

        }
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - Detail
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $transaksi = Transaksi::with([
            'user',
            'tiket.event'
        ])->findOrFail($id);

        return view('transaksi.show', compact('transaksi'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - Edit
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $tikets = Tiket::all();

        return view(
            'transaksi.edit',
            compact(
                'transaksi',
                'tikets'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - Update
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $request->validate([

            'tiket_id' => 'required',

            'nama_pembeli' => 'required',

            'jumlah' => 'required|integer|min:1',

            'total_harga' => 'required|numeric',

            'status' => 'required'

        ]);

        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([

            'tiket_id' => $request->tiket_id,

            'nama_pembeli' => $request->nama_pembeli,

            'jumlah' => $request->jumlah,

            'total_harga' => $request->total_harga,

            'status' => $request->status

        ]);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - Hapus
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->delete();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - Konfirmasi
    |--------------------------------------------------------------------------
    */

    public function konfirmasi(Request $request, $id)
    {
        $request->validate([

            'status' => 'required|in:Pending,Confirmed,Rejected'

        ]);

        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([

            'status' => $request->status

        ]);

        return back()->with(
            'success',
            'Status transaksi berhasil diperbarui.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | USER - Beli Tiket
    |--------------------------------------------------------------------------
    */

    public function beli($id)
    {
        DB::beginTransaction();

        try {

            $tiket = Tiket::findOrFail($id);

            if ($tiket->stok <= 0) {

                return back()->with(
                    'error',
                    'Maaf, stok tiket habis.'
                );

            }

            $jumlah = 1;

            $total = $jumlah * $tiket->harga;

            Transaksi::create([

                'user_id' => auth()->id(),

                'tiket_id' => $tiket->id,

                'nama_pembeli' => auth()->user()->name,

                'jumlah' => $jumlah,

                'total_harga' => $total,

                'status' => 'Pending'

            ]);

            $tiket->decrement('stok', $jumlah);

            DB::commit();

            return redirect()
                ->route('user.riwayat')
                ->with(
                    'success',
                    'Pembelian berhasil. Menunggu konfirmasi admin.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );

        }
    }
}