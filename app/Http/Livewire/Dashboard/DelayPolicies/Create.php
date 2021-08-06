<?php

namespace App\Http\Livewire\Dashboard\DelayPolicies;

use App\Models\DelayPolicy;
use Livewire\Component;

class Create extends Component
{
    public $name_ar;
    public $name_en;
    public $calculate_after;
    public $discount_from_salary;

    protected $rules = [
        'name_ar' => 'required|string|min:3|max:25',
        'name_en' => 'required|string|min:3|max:25',
        'calculate_after' => 'required|integer',
        'discount_from_salary' => 'required|numeric'
    ];

    public function submit()
    {
        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;

        DelayPolicy::create($validatedData);

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
        return view('livewire.dashboard.delay-policies.create');
    }
}
