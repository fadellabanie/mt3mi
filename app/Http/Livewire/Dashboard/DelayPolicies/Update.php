<?php

namespace App\Http\Livewire\Dashboard\DelayPolicies;

use App\Models\DelayPolicy;
use Livewire\Component;

class Update extends Component
{
    public $delayPolicy;

    protected $rules = [
        'delayPolicy.name_ar' => 'required|string|min:3|max:25',
        'delayPolicy.name_en' => 'required|string|min:3|max:25',
        'delayPolicy.calculate_after' => 'required|integer',
        'delayPolicy.discount_from_salary' => 'required|numeric'
    ];

    public function submit()
    {
        $this->delayPolicy->save();

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function mount(DelayPolicy $delayPolicy)
    {
        $this->delayPolicy = $delayPolicy;
    }

    public function render()
    {
        return view('livewire.dashboard.delay-policies.update');
    }
}
