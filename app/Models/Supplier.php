<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name',
        'code',
        'contact_name',
        'email',
        'phone',
    ];
    
    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }
}
