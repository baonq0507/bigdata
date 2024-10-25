<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarrierToken extends Model
{

    protected $fillable = [
        'carrier_name',
        'token',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
