<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TillOperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'till_id',
        'business_date',
        'type',
        'amount',
        'note',
    ];

    public function till()
    {
        return $this->belongsTo(Till::class);
    }
}
