<?php

namespace App\Http\Livewire\Dashboard\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $code;
    public $contact_name;
    public $email;
    public $phone;

    protected $rules = [
        'name'=> 'required|string|min:3|max:25',
        'code' => 'nullable|string|min:3|max:25',
        'contact_name' => 'nullable|string|min:3|max:25',
        'email' => 'nullable|string|email|max:255',
        'phone' => ['nullable', 'regex:/^(5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
    ];

    public function submit()
    {
        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;

        Supplier::create($validatedData);

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
        return view('livewire.dashboard.suppliers.create');
    }
}
