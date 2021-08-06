<?php

namespace App\Models\Presenters;

trait TimedEventPresenter
{
    public static $types = [
        'fixed_price' => 'Fixed Price',
        'reduce_price_by_amount' => 'Reduce price by Amount',
        'reduce_price_by_percentage' => 'Reduce price by Percentage',
        'increase_price_by_amount' => 'Increase price by Amount',
        'increase_price_by_percentage' => 'Increase price by Percentage',
        'activation' => 'Activation',
        'deactivation' => 'Deactivation'
    ];

    public function getTypeFormatAttribute()
    {
        return self::$types[$this->type];
    }

    public function getValueFormatAttribute()
    {
        if (in_array($this->type, ['activation', 'deactivation'])) {
            return "<i class='flaticon2-check-mark text-success'></i>";
        }

        return '<span dir="ltr">' . $this->value . ' SAR </span>';
    }

    public function getStatusAttribute()
    {
        if ($this->is_active) {
            return __('Yes');
        }

        return __('No');
    }
}
