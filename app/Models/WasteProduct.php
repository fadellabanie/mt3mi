<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static $modelClasses = [
        'product' => ProductSize::class,
        'modifier' => ModifierOption::class,
        'item' => InventoryItem::class,
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function productSize()
    {
        return $this->belongsTo(ProductSize::class, 'model_id', 'id');
    }

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class,'model_id', 'id');
    }
}
