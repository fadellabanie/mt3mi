<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name_ar',
        'name_en',
        'icon',
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

    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }
}
