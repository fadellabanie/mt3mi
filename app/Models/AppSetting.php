<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class AppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'order_type_id',
        'logout_inactive_after',
        'reset_order_number_after',
        'void_require_customer_info',
        'discount_require_customer_info',
        'run_in_submode',
        'receipt_language',
        'waiter_app_background',
        'cashier_app_background',
        'customer_app_background',
        'receipt_logo',
        'receipt_header',
        'receipt_footer',
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function orderType()
    {
        return $this->belongsTo(OrderType::class);
    }
}
