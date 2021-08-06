<?php

namespace App\Models;

use App\Models\Presenters\DelayPolicyPresenter;
use App\Support\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DelayPolicy extends Model
{
    use HasFactory;
    use Translatable;
    use DelayPolicyPresenter;
    use SoftDeletes;
    
    protected $fillable = [
        'restaurant_id',
        'name_ar',
        'name_en',
        'calculate_after',
        'discount_from_salary'
    ];

    protected $translatedAttributes = [
        'name'
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }
}
