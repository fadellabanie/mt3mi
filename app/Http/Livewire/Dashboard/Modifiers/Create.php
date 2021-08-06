<?php

namespace App\Http\Livewire\Dashboard\Modifiers;

use App\Models\Modifier;
use Livewire\Component;

class Create extends Component
{
    public $name_ar;
    public $name_en;
    public $sku;
    public $barcode;
    public $is_multiple = 0;
    public $options;

    protected $listeners = ['optionUpdated'];

    protected $rules = [
        'name_ar' => 'required|string|min:3|max:25',
        'name_en' => 'required|string|min:3|max:25',
        'sku' => 'nullable|string',
        'barcode' => 'nullable|string',
        'is_multiple' => 'boolean'
    ];

    public function optionUpdated($options)
    {
        $this->options = $options;
    }

    public function submit()
    {
        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;

        if ($this->is_multiple && is_null($this->options)) {
            return $this->dispatchBrowserEvent('swal', [
                'title' => __('A modifier must have at least 1 option.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);

        }

        $modifier = Modifier::create($validatedData);

        if ($this->is_multiple) {
            foreach ($this->options as $option) {
                $modifier->modifierOptions()->create([
                    'name_ar' => $option['name_ar'],
                    'name_en' => $option['name_en'],
                    'sku' => $option['sku'],
                    'cost_type' => $option['cost_type'],
                    'cost' => $option['cost'],
                    'is_taxable' => $option['is_taxable'],
                    'calories' => $option['calories'],
                    'price' => $option['price']
                ]);
            }
        }

        session()->flash('alert', __('Saved Successfully.'));

        return redirect()->route('dashboard.modifiers.index');
    }

    public function render()
    {
        return view('livewire.dashboard.modifiers.create');
    }
}
