<?php

namespace App\Http\Livewire\Dashboard\TimedEvents;

use App\Models\OrderType;
use Livewire\Component;
use App\Support\WeekDay;
use App\Models\TimedEvent;

class Create extends Component
{
    public $name_ar;
    public $name_en;
    public $type;
    public $value;
    public $is_active = false;
    public $from_date;
    public $to_date;
    public $from_hour;
    public $to_hour;
    public $days = [];
    public $timedEventOrderTypes = [];

    protected $rules = [
        'name_ar' => 'required|min:3|max:25',
        'name_en' => 'required|min:3|max:25',
        'type' => 'required',
        'is_active' => 'boolean',
        'from_date' => "required|date|date_format:Y-m-d|after_or_equal:today",
        'to_date' => 'required|date|date_format:Y-m-d|after_or_equal:from_date',
        'from_hour' => 'required',
        'to_hour' => 'required',
        'days' => 'required|array',
        'timedEventOrderTypes' => 'required|array'
    ];

    public function submit()
    {
        if (!in_array($this->type, ['activation', 'deactivation'])) {
            $this->rules['value'] = 'required|numeric';
        }

        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;

        $validatedData['value'] = (! in_array($this->type, ['activation', 'deactivation'])) ? $this->value : 0;

        $timedEvent = TimedEvent::create($validatedData);

        foreach($this->timedEventOrderTypes as $timedEventOrderType) {
            $timedEvent->timedEventOrderTypes()->create([
                'order_type_id' => $timedEventOrderType
            ]);
        }

        foreach ($this->days as $day) {
            $timedEvent->timedEventDays()->create([
                'day' => $day
            ]);
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
        return view('livewire.dashboard.timed-events.create', [
            'orderTypes' => OrderType::all(),
            'types' => TimedEvent::$types,
            'weekDays' => WeekDay::days()
        ]);
    }
}
