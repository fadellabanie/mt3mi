<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimedEventDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'timed_event_id',
        'day',
    ];
}
