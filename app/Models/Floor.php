<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'restaurant_id',
        'name_ar',
        'name_en',
    ];

    protected $translatedAttributes = [
        'name',
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}
