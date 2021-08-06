<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'cashier_id',
        'order_type_id',
        'work_shift_id',
        'persons',
        'notes',
        'call_name',
        'coupon_id',
        'due_time',
        'join_order',
        'status',
        'payment_method_id',
        'subtotal',
        'discount',
        'total',
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    } 
    public function scopeDone($query)
    {
        return $query->where('order_type_id',1);
    }

    public function scopeStatus($query, $status = 'new')
    {
        return $query->where('status', $status);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id', 'id');
    }

    public function orderType()
    {
        return $this->belongsTo(OrderType::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
