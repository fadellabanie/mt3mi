<?php

namespace App\Http\Livewire\Dashboard\Settings;

use Livewire\Component;
use App\Models\BusinessInfo;

class UpdateBusinessInfo extends Component
{
    public BusinessInfo $businessInfo;

    protected $rules = [
        'businessInfo.company' => 'nullable|string|min:3|max:50',
        'businessInfo.business_reference' => 'nullable|string|max:255'
    ];

    public function submit()
    {
        $this->validate();

        $this->businessInfo->save();

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function mount()
    {
        $this->businessInfo = BusinessInfo::firstOrCreate([
            'restaurant_id' => auth()->user()->restaurant_id
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.settings.update-business-info');
    }
}
