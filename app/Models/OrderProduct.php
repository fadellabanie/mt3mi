<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_size_id',
        'quantity',
        'price',
        'discount',
        'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function productSize()
    {
        return $this->belongsTo(ProductSize::class);
    }

    public function orderProductModifiers()
    {
        return $this->hasMany(OrderProductModifier::class);
    }
}
