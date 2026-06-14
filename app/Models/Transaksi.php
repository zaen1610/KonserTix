<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'tiket_id',
        'nama_pembeli',
        'jumlah',
        'total_harga',
        'status'
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }
}