<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModifierItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'modifier_id',
        'inventory_item_id',
        'quantity',
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }
}
