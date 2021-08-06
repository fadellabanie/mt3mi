<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles ,SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name',
        'type',
        'is_owner',
        'dial_code',
        'phone',
        'email',
        'employee_number',
        'username',
        'password',
        'pin_code',
        'salary',
        'business_role',
        'language',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeRestaurant($query)
    {
        return $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    public function shop()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }

    public function getAvatarAttribute()
    {
        return 'http://unavatar.now.sh/' . urlencode($this->email) . '?' . http_build_query([
            'fallback' => 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF'
        ]);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function lastAttendance()
    {
        return $this->hasOne(Attendance::class, 'user_id')->latest();
    }

    public function isAdmin()
    {
        return in_array($this->type, ['super admin', 'admin']);
    }

    public function isVendor()
    {
        return in_array($this->type, ['owner', 'web user']);
    }
}
