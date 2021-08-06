<?php

namespace App\Http\Livewire\Dashboard\WorkShifts;

use Livewire\Component;
use App\Support\WeekDay;
use App\Models\WorkShift;

class Update extends Component
{
    public $workShift;
    public $days;

    protected $rules = [
        'workShift.name_ar' => 'required|min:3|max:25',
        'workShift.name_en' => 'required|min:3|max:25',
        'workShift.from_time' => 'required',
        'workShift.to_time' => 'required',
        'days' => 'required|array',
    ];

    public function submit()
    {
        $this->validate();

        $this->workShift->save();

        $this->workShift->workShiftDays()->delete();

        foreach ($this->days as $day) {
            $this->workShift->workShiftDays()->create([
                'day' => $day
            ]);
        }

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function mount(WorkShift $workShift)
    {
        $this->$workShift =$workShift;
        $this->days = $workShift->workShiftDays()->pluck('day')->all();
    }

    public function render()
    {
        return view('livewire.dashboard.work-shifts.update', [
            'weekDays' => WeekDay::days()
        ]);
    }
}
