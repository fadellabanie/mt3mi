<?php

namespace App\Models;

use App\Models\Presenters\PaymentMethodPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory;
    use PaymentMethodPresenter;
    use SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name',
        'code',
        'type',
        'auto_open_cash_drawer',
        'is_active',
    ];

    protected $casts = [
        'auto_open_cash_drawer' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }
}
