<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name_ar',
        'name_en',
        'sku',
        'parent_id',
        'icon',
        'is_active',
        'position',
    ];

    protected $translatedAttributes = [
        'name'
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function father()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function timedEvents()
    {
        return $this->belongsToMany(TimedEvent::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
