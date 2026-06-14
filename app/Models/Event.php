<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'kategori_event_id',
        'lokasi_id',
        'nama_event',
        'tanggal',
        'deskripsi',
        'gambar'
    ];

    public function kategori()
    {
        // FK pada tabel events bernama `kategori_id`
        return $this->belongsTo(KategoriEvent::class, 'kategori_id');
    }


    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function tikets()
    {
       return $this->hasMany(Tiket::class, 'event_id');
    }
}