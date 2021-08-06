<?php

namespace App\Http\Livewire\Dashboard\PaymentMethods;

use Livewire\Component;
use App\Models\PaymentMethod;

class Update extends Component
{
    public PaymentMethod $paymentMethod;
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

        if (in_array($this->type, ['Card', 'Others'])) {
            $validatedData['auto_open_cash_drawer'] = ($this->auto_open_cash_drawer) ? true : false;
        }

        $validatedData['is_active'] = ($this->is_active) ? true : false;

        $this->paymentMethod->update($validatedData);

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function mount(PaymentMethod $paymentMethod)
    {
        $this->name = $paymentMethod->name;
        $this->code = $paymentMethod->code;
        $this->type = $paymentMethod->type;
        $this->auto_open_cash_drawer = $paymentMethod->auto_open_cash_drawer;
        $this->is_active = $paymentMethod->is_active;
    }

    public function render()
    {
        return view('livewire.dashboard.payment-methods.update');
    }
}
