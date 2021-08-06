<?php

namespace App\Http\Livewire\Dashboard\FinancialSettings;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\FinancialSetting;

class Update extends Component
{
    public FinancialSetting $financialSetting;

    public function rules()
    {
        return [
            'financialSetting.name' => ['required', 'string', 'min:3', 'max:50', Rule::unique('financial_settings', 'name')->ignore($this->financialSetting->id)],
            'financialSetting.percentage' => ['required', 'numeric', 'min:0'],
            'financialSetting.start_date' => ['required', 'date'],
        ];
    }

    public function submit()
    {
        $this->validate();

        $this->financialSetting->save();

        session()->flash('alert', __('Saved Successfully.'));

        return redirect()->route('dashboard.financial-settings.index');
    }

    public function render()
    {
        return view('livewire.dashboard.financial-settings.update')->layout('layouts.admin');
    }
}
