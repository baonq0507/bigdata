<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_image',
        'product_image',
        'description',
        'total_amount',
        'deposit_amount',
        'confirmation_a',
        'confirmation_b',
        'confirmation_c',
        'code',
        'terms_agreed',
        'status',
        'id_party_b_info',
        'id_party_a_info',
        'post_id',
        'id_user_b',
        'viewed_a',
        'viewed_b',
        'viewed',
        'estimated_delivery_date',
    ];

    const STATUS = [
        'new', 'accepted', 'picking', 'failed_to_pick', 'picked', 'shipping',
        'delivering', 'retry_delivery', 'delivered_successfully', 'pending', 'return_initiated',
        'returned', 'cancellation_requested', 'return_in_progress', 'continue_delivery',
        'shop_cancellation', 'vtp_cancellation'
    ];

    public function partyAInfo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PartyAInfo::class, 'id_party_a_info');
    }

    public function partyBInfo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PartyBInfo::class, 'id_party_b_info');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user_b');
    }

    public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class, 'contract_id');
    }

    public function formatStatus(): string
    {
        switch ($this->status) {
            case 'new':
                return 'Chưa thanh toán';
            case 'accepted':
                return 'Đã thanh toán';
            case 'picking':
                return 'Đang lấy hàng';
            case 'failed_to_pick':
                return 'Không lấy được hàng';
            case 'picked':
                return 'Đã lấy hàng';
            case 'shipping':
                return 'Đang giao hàng';
            case 'delivering':
                return 'Đang giao hàng';
            case 'retry_delivery':
                return 'Giao hàng lại';
            case 'delivered_successfully':
                return 'Giao hàng thành công';
            case 'pending':
                return 'Chờ xử lý';
            case 'return_initiated':
                return 'Đã yêu cầu trả hàng';
            case 'returned':
                return 'Đã trả hàng';
            case 'cancellation_requested':
                return 'Đã yêu cầu hủy';
            case 'return_in_progress':
                return 'Trả hàng đang tiến hành';
            case 'continue_delivery':
                return 'Tiếp tục giao hàng';
            case 'shop_cancellation':
                return 'Hủy bởi shop';
            case 'vtp_cancellation':
                return 'Hủy bởi VTP';
            default:
                return $this->status;
        }
    }

}
