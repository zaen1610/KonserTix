<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $fillable = [
        'event_id',
        'jenis',
        'harga',
        'stok'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // TAMBAHKAN INI
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}