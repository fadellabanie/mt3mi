<?php

namespace App\Http\Livewire\Dashboard\LoyalPoints;

use App\Models\LoyalPoint;
use Livewire\Component;

class Update extends Component
{
    public $loyalPoint;

    protected $rules = [
        'loyalPoint.name_ar' => 'required|string|min:3|max:25',
        'loyalPoint.name_en' => 'required|string|min:3|max:25',
        'loyalPoint.points' => 'required|numeric',
        'loyalPoint.discount' => 'required|numeric'
    ];

    public function submit()
    {
        $this->validate();

        $this->loyalPoint->save();

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function mount(LoyalPoint $loyalPoint)
    {
        $this->loyalPoint = $loyalPoint;
    }

    public function render()
    {
        return view('livewire.dashboard.loyal-points.update');
    }
}
