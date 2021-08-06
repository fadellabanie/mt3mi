<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name_ar',
        'name_en',
        'type',
        'sku',
        'barcode',
        'quantity',
        'purchase_unit',
        'storage_unit',
        'ingredient_unit',
        'purchase_to_storage_factor',
        'storage_to_ingredient_factor',
        'cost_type',
        'cost',
        'minimum_level_alert',
        'supplier_id',
        'expiration_date',
    ];

    protected $translatedAttributes = [
        'name'
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function ingredients()
    {
        return $this->hasMany(InventoryItemIngredient::class, 'inventory_item_id');
    }
}
