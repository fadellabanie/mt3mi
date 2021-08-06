<?php

namespace App\Http\Livewire\Dashboard\FinancialSettings;

use App\Models\FinancialSetting;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $percentage;
    public $start_date;

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:financial_settings,name'],
            'percentage' => ['required', 'numeric', 'min:0'],
            'start_date' => ['required', 'date'],
        ];
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;

        FinancialSetting::create($validatedData);

        session()->flash('alert', __('Saved Successfully.'));

        return redirect()->route('dashboard.financial-settings.index');
    }

    public function render()
    {
        return view('livewire.dashboard.financial-settings.create')->layout('layouts.admin');
    }
}
