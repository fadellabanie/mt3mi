<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSize extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'product_id',
        'name_ar',
        'name_en',
        'barcode',
        'sku',
        'calories',
        'cost_type',
        'cost',
        'price',
        'is_active'
    ];

    protected $translatedAttributes = [
        'name'
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
