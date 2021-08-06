<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;


    protected $fillable = [
        'account_number',
        'name',
        'registered_at',
        'subscription_end_date',
        'is_active'
    ];

    protected static function booted()
    {
        static::created(function ($restaurant) {
            $restaurant->account_number = self::generateAccountNumber();
            $restaurant->save();
        });
    }

    public static function generateAccountNumber()
    {
        $accountNumber = mt_rand(100000, 999999);

        if (self::where('account_number', $accountNumber)->exists()) {
            return self::generateAccountNumber();
        }

        return $accountNumber;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function owner()
    {
        return $this->hasOne(User::class, 'restaurant_id', 'id')->where('is_owner', 1);
    }

    public function hasValidSubscription()
    {
        return (bool) Carbon::parse($this->subscription_end_date) >= Carbon::today();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments');
    }
}
