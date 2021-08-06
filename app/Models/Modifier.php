<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modifier extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name_ar',
        'name_en',
        'sku',
        'barcode',
        'is_multiple',
        'is_active'
    ];

    protected $translatedAttributes = [
        'name'
    ];

    protected $casts = [
        'is_multiple' => 'boolean'
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function modifierOptions()
    {
        return $this->hasMany(ModifierOption::class);
    }

    public function products()
    {
        return $this->hasMany(ProductModifier::class);
    }

    public function modifierItems()
    {
        return $this->hasMany(ModifierItem::class);
    }
}
