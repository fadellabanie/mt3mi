<?php

namespace App\Http\Livewire\Dashboard\Options;

use Livewire\Component;

class Create extends Component
{
    public $options;
    public $name_ar;
    public $name_en;
    public $sku;
    public $cost_type = 'variable';
    public $cost = 0;
    public $is_taxable = 1;
    public $calories = 0;
    public $price = 0;
    public $selectedOption;
    public $action;

    public function create()
    {
        $this->reset([
            'name_ar',
            'name_en',
            'sku',
            'cost_type',
            'cost',
            'is_taxable',
            'calories',
            'price'
        ]);

        $this->resetForm();

        $this->dispatchBrowserEvent('show-create-option-modal');
    }

    public function store()
    {
        $this->validate([
            'name_ar' => 'required|string|min:3|max:25',
            'name_en' => 'required|string|min:3|max:25',
            'sku' => 'nullable|string',
            'cost_type' => 'required',
            'cost' => 'nullable|numeric|required_if:cost_type,fixed',
            'is_taxable' => 'boolean',
            'calories' => 'nullable|numeric',
            'price' => 'nullable|numeric'
        ]);

        $this->options->push([
            'uid' => time(),
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'sku' => $this->sku,
            'cost_type' => $this->cost_type,
            'cost' => ($this->cost_type == 'fixed') ? $this->cost : 0,
            'is_taxable' => $this->is_taxable,
            'calories' => $this->calories,
            'price' => $this->price
        ]);

        $this->emit('optionUpdated', $this->options);
        $this->dispatchBrowserEvent('optionUpdated');

        $this->reset([
            'name_ar',
            'name_en',
            'sku',
            'cost_type',
            'cost',
            'is_taxable',
            'calories',
            'price'
        ]);

        $this->dispatchBrowserEvent('hide-create-option-modal');
    }

    public function selectOption($uid, $action)
    {
        $this->selectedOption = $uid;

        if ($action == 'delete') {
            $this->delete();
        } else {
            $option = $this->options->where('uid', $this->selectedOption)->first();

            $this->name_ar = $option['name_ar'];
            $this->name_en = $option['name_en'];
            $this->sku = $option['sku'];
            $this->cost_type = $option['cost_type'];
            $this->cost = $option['cost'];
            $this->is_taxable = $option['is_taxable'];
            $this->calories = $option['calories'];
            $this->price = $option['price'];

            $this->resetForm();

            $this->dispatchBrowserEvent('show-edit-option-modal');
        }
    }

    public function update()
    {
        $this->validate([
            'name_ar' => 'required|string|min:3|max:25',
            'name_en' => 'required|string|min:3|max:25',
            'sku' => 'nullable|string',
            'cost_type' => 'required',
            'cost' => 'nullable|numeric|required_if:cost_type,fixed',
            'is_taxable' => 'boolean',
            'calories' => 'nullable|numeric',
            'price' => 'nullable|numeric'
        ]);

        $option = $this->options->where('uid', $this->selectedOption)->first();

        $this->options = $this->options->keyBy('uid');

        $this->options->forget($this->selectedOption);

        $this->options->push([
            'uid' =>  $option['uid'],
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'sku' => $this->sku,
            'cost_type' => $this->cost_type,
            'cost' => ($this->cost_type == 'fixed') ? $this->cost : 0,
            'is_taxable' => $this->is_taxable,
            'calories' => $this->calories,
            'price' => $this->price
        ]);

        $this->emit('optionUpdated', $this->options);
        $this->dispatchBrowserEvent('optionUpdated');

        $this->dispatchBrowserEvent('hide-edit-option-modal');
    }

    public function delete()
    {
        if (count($this->options) == 1) {
            $this->dispatchBrowserEvent('swal', [
                'title' => __('A modifier must have at least 1 option.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);

            return;
        }

        $this->options = $this->options->keyBy('uid');

        $this->options->forget($this->selectedOption);

        $this->emit('optionUpdated', $this->options);
        $this->dispatchBrowserEvent('optionUpdated');
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function mount()
    {
        $this->options = collect();
    }

    public function render()
    {
        return view('livewire.dashboard.options.create.datatable');
    }
}
