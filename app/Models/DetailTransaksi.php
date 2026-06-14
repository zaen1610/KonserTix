<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
public function store(Request $request)
{
    $tiket = Tiket::find(
        $request->tiket_id
    );

    $total =
    $tiket->harga *
    $request->jumlah;

    Transaksi::create([

        'tiket_id'=>
        $request->tiket_id,

        'nama_pembeli'=>
        $request->nama,

        'jumlah'=>
        $request->jumlah,

        'total_harga'=>
        $total,

        'status'=>
        'Berhasil'

    ]);

    $tiket->stok -=
    $request->jumlah;

    $tiket->save();

    return redirect(
        '/transaksi'
    );
}
}
