<?php

namespace App\Models\Presenters;

trait CouponPresenter
{
    public function getValueFormatAttribute()
    {
        if ($this->type == 'Value') {
            return '<span dir="ltr">' . $this->value . ' SAR </span>';
        }

        return '<span dir="ltr">' . $this->value . ' % </span>';
    }

    public function getUsedAttribute()
    {
        if ($this->is_used) {
            return __('Yes');
        }

        return __('No');
    }
}
