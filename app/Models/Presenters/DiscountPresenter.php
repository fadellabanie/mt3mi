<?php

namespace App\Models\Presenters;

trait DiscountPresenter
{
    public function getValueFormatAttribute()
    {
        if ($this->type == 'Value') {
            return '<span dir="ltr">' . $this->value . ' SAR </span>';
        }

        return '<span dir="ltr">' . $this->value . ' % </span>';
    }

}
