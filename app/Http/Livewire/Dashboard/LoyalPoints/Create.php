<?php

namespace App\Http\Livewire\Dashboard\LoyalPoints;

use App\Models\LoyalPoint;
use Livewire\Component;

class Create extends Component
{
    public $name_ar;
    public $name_en;
    public $points;
    public $discount;

    protected $rules = [
        'name_ar' => 'required|string|min:3|max:25',
        'name_en' => 'required|string|min:3|max:25',
        'points' => 'required|numeric',
        'discount' => 'required|numeric'
    ];

    public function submit()
    {
        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;

        LoyalPoint::create($validatedData);

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
        return view('livewire.dashboard.loyal-points.create');
    }
}
