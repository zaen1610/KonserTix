<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriEvent extends Model
{
    protected $fillable = [
        'nama_kategori'
    ];

    public function events()
    {
        return $this->hasMany(
            Event::class,
            'kategori_id'
        );
    }
}