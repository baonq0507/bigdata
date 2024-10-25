<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Tên hàng hóa
        'quantity', // Số lượng
        'weight', // Khối lượng
        'delivery_id' // Khóa ngoại liên kết với đơn vị vận chuyển
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class); // Mỗi hàng hóa thuộc về một đơn vị vận chuyển
    }
}
