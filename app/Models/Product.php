<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'category_id',
        'pricing_type',
        'selling_type',
        'sku',
        'barcode',
        'preparation_time',
        'is_taxable',
        'image',
        'is_active',
        'is_combo',
    ];

    protected $translatedAttributes = [
        'name',
        'description'
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeIsCombo($query, $isCombo = true)
    {
        return $query->where('is_combo', $isCombo);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function timedEvents()
    {
        return $this->belongsToMany(TimedEvent::class);
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function productModifiers()
    {
        return $this->hasMany(ProductModifier::class);
    }

    public function productItems()
    {
        return $this->hasMany(ProductItem::class);
    }

    public function productComponents()
    {
        return $this->hasMany(ProductComponent::class);
    }
}
