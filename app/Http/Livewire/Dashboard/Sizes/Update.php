<?php

namespace App\Http\Livewire\Dashboard\Sizes;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductSize;

class Update extends Component
{
    public $product;
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

    protected $listeners = ['triggerRefresh' => '$refresh'];

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

        $this->product->productSizes()->create([
            'name_ar' => $this->name_ar,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'barcode' => $this->barcode,
            'sku' => $this->sku,
            'calories' => $this->calories,
            'cost_type' => $this->cost_type,
            'cost' => ($this->cost_type == 'fixed') ? $this->cost : 0,
            'price' => $this->price
        ]);

        $this->sizes = $this->product->productSizes;

        $this->emit('triggerRefresh');

        $this->dispatchBrowserEvent('hide-create-size-modal');
    }

    public function selectSize($id, $action)
    {
        //dd($id);
        $this->selectedSize = $id;
        
        if ($action == 'delete') {
            $this->delete();
        } else {
            $size = ProductSize::where('id', $this->selectedSize)->first();

            $this->name_ar = $size->name_ar;
            $this->name_en = $size->name_en;
            $this->barcode = $size->barcode;
            $this->sku = $size->sku;
            $this->calories = $size->calories;
            $this->cost_type = $size->cost_type;
            $this->cost = $size->cost;
            $this->price = $size->price;

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

        ProductSize::where('id', $this->selectedSize)->update([
            'name_ar' => $this->name_ar,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'barcode' => $this->barcode,
            'sku' => $this->sku,
            'calories' => $this->calories,
            'cost_type' => $this->cost_type,
            'cost' => ($this->cost_type == 'fixed') ? $this->cost : 0,
            'price' => $this->price
        ]);

        $this->emit('triggerRefresh');

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

        ProductSize::where('id', $this->selectedSize)->delete();

        $this->emit('triggerRefresh');
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->sizes = $product->productSizes;
        
    }

    public function render()
    {
        return view('livewire.dashboard.sizes.update.datatable');
    }
}
