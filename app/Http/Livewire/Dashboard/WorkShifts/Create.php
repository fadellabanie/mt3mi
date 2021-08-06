<?php

namespace App\Http\Livewire\Dashboard\WorkShifts;

use App\Models\WorkShift;
use Livewire\Component;
use App\Support\WeekDay;

class Create extends Component
{
    public $name_ar;
    public $name_en;
    public $from_time;
    public $to_time;
    public $days = [];

    protected $rules = [
        'name_ar' => 'required|min:3|max:25',
        'name_en' => 'required|min:3|max:25',
        'from_time' => 'required',
        'to_time' => 'required',
        'days' => 'required|array'
    ];

    public function submit()
    {
        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;

        $workShift = WorkShift::create($validatedData);

        foreach ($this->days as $day) {
            $workShift->workShiftDays()->create([
                'day' => $day
            ]);
        }

        $this->reset();

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function render()
    {
        return view('livewire.dashboard.work-shifts.create', [
            'weekDays' => WeekDay::days()
        ]);
    }
}
