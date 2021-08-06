<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\InventoryItem;
use App\Models\Product;
use App\Models\ProductItem;
use Livewire\Component;

class ProductItems extends Component
{
    public $name = '';
    public $product;
    public $productSizes;
    public $productItems;
    public $inventory_item_id;
    public $ingredient_unit;
    public $quantity = [];
    public $is_optional = 0;
    public $unit = '';
    public $selectedInventoryItem;
    public $action;
    public $items;

    protected $listeners = ['triggerRefresh' => '$refresh'];

    public function updatedInventoryItemId()
    {
        $this->unit = InventoryItem::where('id', $this->inventory_item_id)->value('ingredient_unit');
    }

    public function create()
    {
        $this->reset([
            'inventory_item_id',
            'quantity',
            'is_optional',
            'unit'
        ]);

        $this->resetForm();

        $this->dispatchBrowserEvent('show-create-item-modal');
    }

    public function store()
    {
        $this->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'quantity.*' => 'required|numeric|min:0',
            'is_optional' => 'boolean'
        ]);

        if(count($this->quantity) == 0) {
            $this->dispatchBrowserEvent('swal', [
                'title' => __('Quantity must be zero or more in all sizes.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);

            return;
        }

        if (!is_null(ProductItem::where([
            ['product_id', '=', $this->product->id],
            ['inventory_item_id', '=', $this->inventory_item_id]
        ])->first())) {
            $this->dispatchBrowserEvent('swal', [
                'title' => __('Ingredient already exists.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);

            return;
        }

        foreach ($this->productSizes as $key => $productSize) {
            ProductItem::create([
                'product_id' => $this->product->id,
                'product_size_id' => $productSize->id,
                'inventory_item_id' => $this->inventory_item_id,
                'quantity' => $this->quantity[$key],
                'is_optional' => $this->is_optional
            ]);
        }

        $this->productItems = $this->product->productItems()->with(['inventoryItem', 'productSize'])->groupBy('inventory_item_id')->get();

        $this->dispatchBrowserEvent('hide-create-item-modal');
    }

    public function selectItem($inventoryItemId, $action)
    {
        $this->selectedInventoryItem = $inventoryItemId;

        if ($action == 'delete') {
            $this->delete();
        } else {
            $inventroyItem = InventoryItem::where('id', $inventoryItemId)->first();

            $this->name = $inventroyItem->name;

            $this->unit = $inventroyItem->ingredient_unit;

            $this->items = ProductItem::with(['productSize'])->where([
                ['product_id', '=', $this->product->id],
                ['inventory_item_id', '=', $this->selectedInventoryItem]
            ])->get();

            foreach ($this->items as $key => $item) {
                $this->quantity[$key] = $item->quantity;
            }

            $this->is_optional = $this->items[0]->is_optional;

            $this->resetForm();

            $this->dispatchBrowserEvent('show-edit-item-modal');
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
            ProductItem::where([
                'product_id' => $this->product->id,
                'inventory_item_id' => $this->selectedInventoryItem,
                'product_size_id' => $item->productSize->id
            ])->update([
                'quantity' => $this->quantity[$key],
                'is_optional' => $this->is_optional
            ]);
        }

        $this->dispatchBrowserEvent('hide-edit-item-modal');
    }

    public function delete()
    {
        ProductItem::where([
            ['product_id', '=', $this->product->id],
            ['inventory_item_id', '=', $this->selectedInventoryItem]
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
        $this->productItems = $product->productItems()->with(['inventoryItem', 'productSize'])->groupBy('inventory_item_id')->get();
        $this->productSizes = $product->productSizes;
    }

    public function render()
    {
        return view('livewire.dashboard.product-items.datatable', [
            'inventoryItems' => InventoryItem::restaurant()->get()
        ]);
    }
}
