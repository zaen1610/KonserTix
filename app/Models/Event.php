<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tiket; // ✅ TAMBAHAN INI

class Event extends Model
{
   protected $fillable = [
    'kategori_id',
    'lokasi_id',
    'nama_event',
    'deskripsi',
    'tanggal',
    'jam',
    'poster'
];

    public function kategori()
    {
        return $this->belongsTo(KategoriEvent::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }
}