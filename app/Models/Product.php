<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'field',
        'contract_id',
        'name',
        'color',
        'quantity',
        'price',
        'gender',
        'size',
        'material',
        'description',
    ];

    protected $casts = [
        'size' => 'array',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
