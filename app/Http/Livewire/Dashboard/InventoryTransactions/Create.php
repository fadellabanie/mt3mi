<?php

namespace App\Http\Livewire\Dashboard\InventoryTransactions;

use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use App\Models\Supplier;
use Livewire\Component;

class Create extends Component
{
    public $supplier_id;
    public $invoice_number;
    public $invoice_date;
    public $paid_tax = 0;
    public $notes;
    public $inventory_item_id;
    public $purchase_quantity = 0;
    public $storage_quantity = 0;
    public $ingredient_quantity = 0;
    public $cost = 0;
    public $expiration_date;
    public $purchase_unit = '';
    public $storage_unit = '';
    public $ingredient_unit = '';

    protected $rules = [
        'supplier_id' => 'required|exists:suppliers,id',
        'invoice_number' => 'nullable|string',
        'invoice_date' => 'nullable|date',
        'paid_tax' => 'numeric|min:0',
        'notes' => 'nullable|string',
        'inventory_item_id' => 'required|exists:inventory_items,id',
        'purchase_quantity' => 'integer|min:0',
        'storage_quantity' => 'integer|min:0',
        'ingredient_quantity' => 'integer|min:0',
        'cost' => 'numeric|min:0',
        'expiration_date' => 'nullable|date'
    ];

    public function updatedInventoryItemId()
    {
        $inventoryItem = InventoryItem::where('id', $this->inventory_item_id)->first();

        $this->purchase_unit = $inventoryItem->purchase_unit;
        $this->storage_unit = $inventoryItem->storage_unit;
        $this->ingredient_unit = $inventoryItem->ingredient_unit;
    }

    public function submit()
    {
        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;

        InventoryTransaction::create($validatedData);

        session()->flash('alert', __('Saved Successfully.'));

        return redirect()->route('dashboard.inventory-transactions.index');
    }

    public function render()
    {
        return view('livewire.dashboard.inventory-transactions.create', [
            'suppliers' => Supplier::restaurant()->get(),
            'inventoryItems' => InventoryItem::restaurant()->get()
        ]);
    }
}
