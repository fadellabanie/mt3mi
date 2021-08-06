<?php

namespace App\Http\Livewire\Dashboard\Coupons;

use App\Models\Coupon;
use App\Support\WeekDay;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $type = 'Value';
    public $value;
    public $valid_from;
    public $valid_to;
    public $from_time;
    public $to_time;
    public $no_of_coupons = 1;
    public $days = [];

    protected $rules = [
        'name' => 'required|min:3|max:25',
        'type' => 'required',
        'value' => 'required|numeric',
        'valid_from' => "required|date|date_format:Y-m-d|after_or_equal:today",
        'valid_to' => 'required|date|date_format:Y-m-d|after_or_equal:valid_from',
        'from_time' => 'nullable',
        'to_time' => 'nullable',
        'no_of_coupons' => 'required|integer|min:1',
    ];

    public function submit()
    {
        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;

        foreach(range(1, $this->no_of_coupons) as $i) {
            $coupon = Coupon::create($validatedData);

            foreach ($this->days as $day) {
                $coupon->couponDays()->create([
                    'day' => $day
                ]);
            }
        }

        $this->reset();

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.dashboard.coupons.create', [
            'weekDays' => WeekDay::days()
        ]);
    }
}
