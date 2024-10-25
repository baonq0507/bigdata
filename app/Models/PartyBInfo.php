<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyBInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'user_id',
        'tax_id',
        'bank_account_number',
        'bank_name',
        'business_name',
        'delivery_id',
        'position',
        'address',
        'phone_number',
        'full_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
