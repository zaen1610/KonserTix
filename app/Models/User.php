<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [

        'name',
        'email',
        'password',
        'role'

    ];

    protected $hidden = [

        'password'

    ];

    public function transaksis()
    {
        return $this->hasMany(
            Transaksi::class
        );
    }
}