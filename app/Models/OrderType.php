<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'name_ar',
        'name_en',
    ];

    protected $translatedAttributes = [
        'name'
    ];
}
