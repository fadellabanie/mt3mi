<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemIngredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_item_id',
        'ingredient_id',
        'quantity'
    ];

    public function ingredient()
    {
        return $this->belongsTo(InventoryItem::class, 'ingredient_id');
    }
}
