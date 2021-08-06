<?php

namespace App\Http\Livewire\Dashboard\Sizes;

use Livewire\Component;

class Create extends Component
{
    public $sizes;
    public $name_ar;
    public $name_en;
    public $barcode;
    public $sku;
    public $calories = 0;
    public $cost_type = 'variable';
    public $cost = 0;
    public $price = 0;
    public $selectedSize;
    public $action;

    public function create()
    {
        $this->reset([
            'name_ar',
            'name_en',
            'barcode',
            'sku',
            'calories',
            'cost_type',
            'cost',
            'price'
        ]);

        $this->resetForm();

        $this->dispatchBrowserEvent('show-create-size-modal');
    }

    public function store()
    {
        $this->validate([
            'name_ar' => 'required|string|min:3|max:25',
            'name_en' => 'required|string|min:3|max:25',
            'barcode' => 'nullable|string|min:3|max:25',
            'sku' => 'nullable|string|min:3|max:25',
            'calories' => 'nullable|numeric',
            'cost_type' => 'required',
            'cost' => 'nullable|numeric|required_if:cost_type,fixed',
            'price' => 'nullable|numeric'
        ]);

        $this->sizes->push([
            'uid' => time(),
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'barcode' => $this->barcode,
            'sku' => $this->sku,
            'calories' => $this->calories,
            'cost_type' => $this->cost_type,
            'cost' => ($this->cost_type == 'fixed') ? $this->cost : 0,
            'price' => $this->price
        ]);

        $this->emit('sizeUpdated', $this->sizes);
        $this->dispatchBrowserEvent('sizeUpdated');

        $this->reset([
            'name_ar',
            'name_en',
            'barcode',
            'sku',
            'calories',
            'cost_type',
            'cost',
            'price'
        ]);

        $this->dispatchBrowserEvent('hide-create-size-modal');
    }

    public function selectSize($uid, $action)
    {
        $this->selectedSize = $uid;

        if ($action == 'delete') {
            $this->delete();
        } else {
            $size = $this->sizes->where('uid', $this->selectedSize)->first();

            $this->name_ar = $size['name_ar'];
            $this->name_en = $size['name_en'];
            $this->barcode = $size['barcode'];
            $this->sku = $size['sku'];
            $this->calories = $size['calories'];
            $this->cost_type = $size['cost_type'];
            $this->cost = $size['cost'];
            $this->price = $size['price'];

            $this->resetForm();

            $this->dispatchBrowserEvent('show-edit-size-modal');
        }
    }

    public function update()
    {
        $this->validate([
            'name_ar' => 'required|string|min:3|max:25',
            'name_en' => 'required|string|min:3|max:25',
            'barcode' => 'nullable|string|min:3|max:25',
            'sku' => 'nullable|string|min:3|max:25',
            'calories' => 'nullable|numeric',
            'cost_type' => 'required',
            'cost' => 'nullable|numeric|required_if:cost_type,fixed',
            'price' => 'nullable|numeric'
        ]);

        $size = $this->sizes->where('uid', $this->selectedSize)->first();

        $this->sizes = $this->sizes->keyBy('uid');

        $this->sizes->forget($this->selectedSize);

        $this->sizes->push([
            'uid' =>  $size['uid'],
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'barcode' => $this->barcode,
            'sku' => $this->sku,
            'calories' => $this->calories,
            'cost_type' => $this->cost_type,
            'cost' => ($this->cost_type == 'fixed') ? $this->cost : 0,
            'price' => $this->price
        ]);

        $this->emit('sizeUpdated', $this->sizes);
        $this->dispatchBrowserEvent('sizeUpdated');

        $this->dispatchBrowserEvent('hide-edit-size-modal');
    }

    public function delete()
    {
        if (count($this->sizes) == 1) {
            $this->dispatchBrowserEvent('swal', [
                'title' => __('A product must have at least 1 size.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);

            return;
        }

        $this->sizes = $this->sizes->keyBy('uid');

        $this->sizes->forget($this->selectedSize);

        $this->emit('sizeUpdated', $this->sizes);
        $this->dispatchBrowserEvent('sizeUpdated');
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function mount()
    {
        $this->sizes = collect();
    }

    public function render()
    {
        return view('livewire.dashboard.sizes.create.datatable');
    }
}
