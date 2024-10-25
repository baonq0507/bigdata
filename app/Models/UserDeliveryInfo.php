<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeliveryInfo extends Model
{
    use HasFactory;

    protected $table = 'user_delivery_info';

    protected $fillable = [
        'user_id',
        'address',
        'district_id',
        'province_id',
        'ward_id',
        'phone',
        'receiver_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
