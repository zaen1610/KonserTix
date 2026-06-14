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

    /*
    |--------------------------------------------------------------------------
    | Relasi ke Event
    |--------------------------------------------------------------------------
    */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi ke Transaksi
    |--------------------------------------------------------------------------
    */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Cek stok tersedia
    |--------------------------------------------------------------------------
    */
    public function stokTersedia($jumlah = 1)
    {
        return $this->stok >= $jumlah;
    }

    /*
    |--------------------------------------------------------------------------
    | Kurangi stok
    |--------------------------------------------------------------------------
    */
    public function kurangiStok($jumlah = 1)
    {
        if ($this->stok >= $jumlah) {

            $this->decrement('stok', $jumlah);

            return true;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Tambah stok
    |--------------------------------------------------------------------------
    */
    public function tambahStok($jumlah = 1)
    {
        $this->increment('stok', $jumlah);
    }
}