<?php

namespace App\Models\Presenters;

trait DelayPolicyPresenter
{
    public function getCalculateAfterFormatAttribute()
    {
        if (app()->getLocale() == 'en') {
            return '<span  dir="ltr">' . $this->calculate_after . ' ' . __('Minute') . '</span>';
        }

        return '<span>' . $this->calculate_after . ' ' . __('Minute') . '</span>';

    }

    public function getDiscountFromSalaryFormatAttribute()
    {
        if (app()->getLocale() == 'en') {
            return '<span dir="ltr">' . $this->discount_from_salary . ' ' . __('Day') . '</span>';
        }

        return '<span>' . $this->discount_from_salary . ' ' . __('Day') . '</span>';
    }
}
