<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryTransaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'restaurant_id',
        'business_date',
        'supplier_id',
        'invoice_number',
        'invoice_date',
        'paid_tax',
        'notes',
        'inventory_item_id',
        'purchase_quantity',
        'storage_quantity',
        'ingredient_quantity',
        'cost',
        'expiration_date',
        'status'
    ];

    protected $casts = [
        'business_date' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }
}
