<?php

namespace App\Models;

use App\Models\Presenters\DiscountPresenter;
use App\Support\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory;
    use Translatable;
    use DiscountPresenter;
    use SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name_ar',
        'name_en',
        'type',
        'value',
        'applies_to',
        'activate_for',
        'is_taxable',
        'start_date'
    ];

    protected $translatedAttributes = [
        'name'
    ];

    protected $casts = [
        'applies_to' => 'array',
        'activate_for' => 'array',
        'is_taxable' => 'boolean'
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
