<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'contract_id',
        'package_image',
        'product_length',
        'product_width',
        'product_height',
        'product_weight',
        'product_note',
        'delivery_user_a_info',
        'delivery_user_b_info',
        'list_products',
        'money_total_ship',
        'service',
        'order_note',
        'order_service',
        'order_service_add',
        'status'
    ];

    /**
     * Get the full path of the package image.
     *
     * @return string
     */
    public function getPackageImagePathAttribute()
    {
        return $this->package_image ? asset('storage/' . $this->package_image) : null;
    }

    /**
     * Scope a query to only include active deliveries.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'delivery_cancelled');
    }

    /**
     * Get the contract that owns the delivery.
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
