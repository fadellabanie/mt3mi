<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShiftDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_shift_id',
        'day',
    ];
}
