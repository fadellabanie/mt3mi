<?php

namespace App\Models;

use App\Models\Presenters\CouponPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory;
    use CouponPresenter;
    use SoftDeletes;
    
    protected $fillable = [
        'restaurant_id',
        'name',
        'code',
        'type',
        'value',
        'valid_from',
        'valid_to',
        'from_time',
        'to_time',
        'created_by',
        'is_active',
        'is_used',
    ];

    protected $casts = [
        'value' => 'float',
        'is_active' => 'boolean',
        'is_used' => 'boolean'
    ];

    protected static function booted()
    {
        static::created(function ($coupon) {
            $coupon->code = self::generateCode();
            $coupon->created_by = auth()->id();
            $coupon->save();
        });
    }

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function couponDays()
    {
        return $this->hasMany(CouponDay::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public static function generateCode()
    {
        $code = mt_rand(100000, 999999);

        if (self::where([
            ['restaurant_id', auth()->user()->restaurant_id],
            ['code', $code],
        ])->exists()) {
            return self::generateCode();
        }

        return $code;
    }
}
