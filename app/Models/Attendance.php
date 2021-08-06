<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'user_id',
        'check_in',
        'check_out',
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function checkout()
    {
        $this->update([
            'check_out' => Carbon::now()
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
