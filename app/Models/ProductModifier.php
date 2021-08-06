<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModifier extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'modifier_id',
        'minimum_options',
        'maximum_options',
    ];

    public function modifier()
    {
        return $this->belongsTo(Modifier::class);
    }
}
