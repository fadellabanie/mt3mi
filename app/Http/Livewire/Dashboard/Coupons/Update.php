<?php

namespace App\Http\Livewire\Dashboard\Coupons;

use App\Models\Coupon;
use Livewire\Component;
use App\Support\WeekDay;

class Update extends Component
{
    public $coupon;
    public $days;

    protected $rules = [
        'coupon.valid_from' => "required|date|date_format:Y-m-d",
        'coupon.valid_to' => 'required|date|date_format:Y-m-d|after_or_equal:valid_from',
        'coupon.from_time' => 'nullable',
        'coupon.to_time' => 'nullable',
        'coupon.is_active' => 'boolean'
    ];

    public function submit()
    {
        $this->validate();

        $this->coupon->from_time = (count($this->days) > 0) ? $this->coupon->from_time : null;
        $this->coupon->to_time = (count($this->days) > 0) ? $this->coupon->to_time : null;

        $this->coupon->save();

        $this->coupon->couponDays()->delete();

        foreach ($this->days as $day) {
            $this->coupon->couponDays()->create([
                'day' => $day
            ]);
        }

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function mount(Coupon $coupon)
    {
        $this->coupon = $coupon;
        $this->days = $coupon->couponDays()->pluck('day');
    }

    public function render()
    {
        return view('livewire.dashboard.coupons.update', [
            'weekDays' => WeekDay::days()
        ]);
    }
}
