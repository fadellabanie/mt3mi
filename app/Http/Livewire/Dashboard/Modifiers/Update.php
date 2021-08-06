<?php

namespace App\Http\Livewire\Dashboard\Modifiers;

use App\Models\Modifier;
use Livewire\Component;

class Update extends Component
{
    public Modifier $modifier;
    public $name_ar;
    public $name_en;
    public $sku;
    public $barcode;
    public $is_multiple = 0;

    protected $rules = [
        'name_ar' => 'required|string|min:3|max:25',
        'name_en' => 'required|string|min:3|max:25',
        'sku' => 'nullable|string',
        'barcode' => 'nullable|string',
        'is_multiple' => 'boolean'
    ];

    public function submit()
    {
        $validatedData = $this->validate();

        $this->modifier->update($validatedData);

        session()->flash('alert', __('Saved Successfully.'));

        return redirect()->route('dashboard.modifiers.index');
    }

    public function mount(Modifier $modifier)
    {
        $this->modifier = $modifier;
        $this->name_ar = $modifier->name_ar;
        $this->name_en = $modifier->name_en;
        $this->sku = $modifier->sku;
        $this->barcode = $modifier->barcode;
        $this->is_multiple = $modifier->is_multiple;
    }

    public function render()
    {
        return view('livewire.dashboard.modifiers.update');
    }
}
