<?php

namespace App\Models\Presenters;

trait PaymentMethodPresenter
{
    public function getCashDrawerStatusAttribute()
    {
        if ($this->auto_open_cash_drawer) {
            return "<i class='flaticon2-check-mark text-success'></i>";
        }

        return '';
    }

    public function getStatusAttribute()
    {
        if ($this->is_active) {
            return "<i class='flaticon2-check-mark text-success'></i>";
        }

        return '';
    }
}
