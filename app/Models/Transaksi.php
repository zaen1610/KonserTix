<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'tiket_id',
        'nama_pembeli',
        'jumlah',
        'total_harga',
        'status',
        'metode_pembayaran',
    ];

    public function tiket()
    {
        // FK transaksis -> tikets dengan kolom tiket_id
        return $this->belongsTo(Tiket::class, 'tiket_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}