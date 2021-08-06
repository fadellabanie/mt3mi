<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'name',
        'percentage',
        'start_date',
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }
}
