<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_size_id',
        'inventory_item_id',
        'quantity',
        'is_optional'
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function productSize()
    {
        return $this->belongsTo(ProductSize::class);
    }
}
