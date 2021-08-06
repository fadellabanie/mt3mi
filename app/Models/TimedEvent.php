<?php

namespace App\Models;

use App\Models\Presenters\TimedEventPresenter;
use App\Support\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimedEvent extends Model
{
    use HasFactory;
    use Translatable;
    use TimedEventPresenter;
    use SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name_ar',
        'name_en',
        'type',
        'value',
        'is_active',
        'from_date',
        'to_date',
        'from_hour',
        'to_hour',
    ];

    protected $translatedAttributes = [
        'name'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function timedEventDays()
    {
        return $this->hasMany(TimedEventDay::class);
    }

    public function timedEventOrderTypes()
    {
        return $this->hasMany(TimedEventOrderType::class);
    }
}
