<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModifierOption extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $fillable = [
        'modifier_id',
        'name_ar',
        'name_en',
        'sku',
        'cost_type',
        'cost',
        'is_taxable',
        'calories',
        'price'
    ];

    protected $translatedAttributes = [
        'name'
    ];

    public function modifier()
    {
        return $this->belongsTo(Modifier::class);
    }
}
