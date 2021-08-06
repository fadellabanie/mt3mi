<?php

namespace App\Http\Livewire\Dashboard\TimedEvents;

use Livewire\Component;
use App\Support\WeekDay;
use App\Models\OrderType;
use App\Models\TimedEvent;

class Update extends Component
{
    public $timedEvent;
    public $days;
    public $timedEventOrderTypes;

    protected $rules = [
        'timedEvent.name_ar' => 'required|min:3|max:25',
        'timedEvent.name_en' => 'required|min:3|max:25',
        'timedEvent.type' => 'required',
        'timedEvent.value' => 'nullable',
        'timedEvent.is_active' => 'boolean',
        'timedEvent.from_date' => "required|date|date_format:Y-m-d|after_or_equal:today",
        'timedEvent.to_date' => 'required|date|date_format:Y-m-d|after_or_equal:from_date',
        'timedEvent.from_hour' => 'required',
        'timedEvent.to_hour' => 'required',
        'days' => 'required|array',
        'timedEventOrderTypes' => 'required|array',
    ];

    public function submit()
    {
        if (!in_array($this->timedEvent->type, ['activation', 'deactivation'])) {
            $this->rules['timedEvent.value'] = 'required|numeric';
        }

        $this->validate();

        $this->timedEvent->value = (!in_array($this->timedEvent->type, ['activation', 'deactivation'])) ? $this->timedEvent->value : 0;

        $this->timedEvent->save();

        $this->timedEvent->timedEventOrderTypes()->delete();

        foreach ($this->timedEventOrderTypes as $timedEventOrderType) {
            $this->timedEvent->timedEventOrderTypes()->create([
                'order_type_id' => $timedEventOrderType
            ]);
        }

        $this->timedEvent->timedEventDays()->delete();

        foreach ($this->days as $day) {
            $this->timedEvent->timedEventDays()->create([
                'day' => $day
            ]);
        }

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function mount(TimedEvent $timedEvent)
    {
        $this->timedEvent = $timedEvent;
        $this->days = $timedEvent->timedEventDays()->pluck('day')->all();
        $this->timedEventOrderTypes = $timedEvent->timedEventOrderTypes()->pluck('order_type_id')->all();
    }

    public function render()
    {
        return view('livewire.dashboard.timed-events.update', [
            'orderTypes' => OrderType::all(),
            'types' => TimedEvent::$types,
            'weekDays' => WeekDay::days()
        ]);
    }
}
