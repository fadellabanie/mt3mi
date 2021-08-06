<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'component_id',
        'product_size_id',
        'quantity',
    ];

    public function component()
    {
        return $this->belongsTo(Product::class, 'component_id', 'id');
    }

    public function productSize()
    {
        return $this->belongsTo(ProductSize::class);
    }
}
