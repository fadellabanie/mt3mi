<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Till extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'user_id',
        'opened_at',
        'closed_at',
    ];

    public $dates = [
        'created_at',
        'updated_at',
        'opened_at',
        'closed_at',
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function scopeCashier($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function operations()
    {
        return $this->hasMany(TillOperation::class);
    }

    public function close()
    {
        $this->update([
            'closed_at' => Carbon::now()
        ]);
    }
}
