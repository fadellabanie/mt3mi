<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Product;
use App\Models\ProductComponent;
use Livewire\Component;

class ProductComponents extends Component
{
    public $name = '';
    public $product;
    public $productSizes;
    public $productComponents;
    public $component_id;
    public $quantity = [];
    public $selectedComponentItem;
    public $action;
    public $items;

    protected $listeners = ['triggerRefresh' => '$refresh'];

    public function create()
    {
        $this->reset([
            'component_id',
            'quantity'
        ]);

        $this->resetForm();

        $this->dispatchBrowserEvent('show-create-component-modal');
    }

    public function store()
    {
        $this->validate([
            'component_id' => 'required|exists:products,id',
            'quantity.*' => 'required|numeric|min:0'
        ]);

        if(count($this->quantity) == 0) {
            $this->dispatchBrowserEvent('swal', [
                'title' => __('Quantity must be zero or more in all sizes.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);

            return;
        }

        if (!is_null(ProductComponent::where([
            ['product_id', '=', $this->product->id],
            ['component_id', '=', $this->component_id]
        ])->first())) {
            return $this->dispatchBrowserEvent('swal', [
                'title' => __('Ingredient already exists.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);
        }

        foreach ($this->productSizes as $key => $productSize) {
            ProductComponent::create([
                'product_id' => $this->product->id,
                'product_size_id' => $productSize->id,
                'component_id' => $this->component_id,
                'quantity' => $this->quantity[$key]
            ]);
        }

        $this->productComponents = $this->product->productComponents()->with(['component', 'productSize'])->groupBy('component_id')->get();

        $this->dispatchBrowserEvent('hide-create-component-modal');
    }

    public function selectItem($componentItemId, $action)
    {
        $this->selectedComponentItem = $componentItemId;

        if ($action == 'delete') {
            $this->delete();
        } else {
            $componentItem = Product::where('id', $componentItemId)->first();

            $this->name = $componentItem->name;

            $this->items = ProductComponent::with(['productSize'])->where([
                ['product_id', '=', $this->product->id],
                ['component_id', '=', $this->selectedComponentItem]
            ])->get();

            foreach ($this->items as $key => $item) {
                $this->quantity[$key] = $item->quantity;
            }

            $this->resetForm();

            $this->dispatchBrowserEvent('show-edit-component-modal');
        }
    }

    public function update()
    {
        if (count($this->quantity) == 0) {
            $this->dispatchBrowserEvent('swal', [
                'title' => __('Quantity must be zero or more in all sizes.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);

            return;
        }

        foreach($this->items as $key => $item)  {
            ProductComponent::where([
                'product_id' => $this->product->id,
                'component_id' => $this->selectedComponentItem,
                'product_size_id' => $item->productSize->id
            ])->update([
                'quantity' => $this->quantity[$key]
            ]);
        }

        $this->dispatchBrowserEvent('hide-edit-component-modal');
    }

    public function delete()
    {
        ProductComponent::where([
            ['product_id', '=', $this->product->id],
            ['component_id', '=', $this->selectedComponentItem]
        ])->delete();

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
        $this->productComponents = $product->productComponents()->with(['component', 'productSize'])->groupBy('component_id')->get();
        $this->productSizes = $product->productSizes;
    }

    public function render()
    {
        return view('livewire.dashboard.product-components.datatable', [
            'components' => Product::restaurant()->get()
        ])->layout('layouts.admin');
    }
}
