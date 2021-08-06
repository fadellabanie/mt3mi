<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductModifier extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_product_id',
        'modifier_option_id',
        'quantity',
        'price',
        'discount',
        'total',
    ];

    public function modifierOption()
    {
        return $this->belongsTo(ModifierOption::class);
    }

    
}
