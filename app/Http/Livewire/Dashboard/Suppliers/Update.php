<?php

namespace App\Http\Livewire\Dashboard\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class Update extends Component
{
    public $supplier;

    protected $rules = [
        'supplier.name' => 'required|string|min:3|max:25',
        'supplier.code' => 'nullable|string|min:3|max:25',
        'supplier.contact_name' => 'nullable|string|min:3|max:25',
        'supplier.email' => 'nullable|string|email|max:255',
        'supplier.phone' => ['nullable', 'regex:/^(5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
    ];

    public function mount(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    public function submit()
    {
        $this->supplier->save();

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function render()
    {
        return view('livewire.dashboard.suppliers.update');
    }
}
