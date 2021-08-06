<?php

namespace App\Http\Livewire\Dashboard\PaymentMethods;

use App\Models\PaymentMethod;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $code;
    public $type;
    public $auto_open_cash_drawer;
    public $is_active;

    protected $rules = [
        'name' => 'required|string|min:3|max:25',
        'code' => 'nullable|string|min:3|max:25',
        'type' => 'required',
        'auto_open_cash_drawer' => 'nullable|boolean',
        'is_active' => 'nullable|boolean'
    ];

    public function submit()
    {
        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;

        if (in_array($this->type, ['Card', 'Others'])) {
            $validatedData['auto_open_cash_drawer'] = ($this->auto_open_cash_drawer) ? true : false;
        }

        $validatedData['is_active'] = ($this->is_active) ? true : false;

        PaymentMethod::create($validatedData);

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
        return view('livewire.dashboard.payment-methods.create');
    }
}
