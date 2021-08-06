<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'floor_id',
        'name_ar',
        'name_en',
        'table_number',
    ];

    protected $translatedAttributes = [
        'name'
    ];
}
