<?php

namespace App\Models\Presenters;

trait LoyalPointPresenter
{
    public function getDiscountFormatAttribute()
    {
        return '<span dir="ltr">' . $this->discount . ' SAR </span>';
    }
}
