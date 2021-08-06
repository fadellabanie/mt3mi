<?php

namespace App\Http\Livewire\Dashboard\InventoryTransactions;

use Livewire\Component;
use App\Models\Supplier;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;

class Show extends Component
{
    public InventoryTransaction $inventoryTransaction;
    public InventoryItem $inventoryItem;
    public $purchase_unit;
    public $storage_unit;
    public $ingredient_unit;

    protected $rules = [
        'inventoryTransaction.supplier_id' => 'required|exists:suppliers,id',
        'inventoryTransaction.invoice_number' => 'nullable|string',
        'inventoryTransaction.invoice_date' => 'nullable|date',
        'inventoryTransaction.paid_tax' => 'numeric|min:0',
        'inventoryTransaction.notes' => 'nullable|string',
        'inventoryTransaction.inventory_item_id' => 'required|exists:inventory_items,id',
        'inventoryTransaction.purchase_quantity' => 'numeric|min:0',
        'inventoryTransaction.storage_quantity' => 'numeric|min:0',
        'inventoryTransaction.ingredient_quantity' => 'numeric|min:0',
        'inventoryTransaction.cost' => 'numeric|min:0',
        'inventoryTransaction.expiration_date' => 'nullable|date'
    ];

    public function mount(InventoryTransaction $inventoryTransaction)
    {
        $this->inventoryTransaction = $inventoryTransaction;
        $this->inventoryItem = $inventoryTransaction->inventoryItem;
        $this->purchase_unit = $inventoryTransaction->inventoryItem->purchase_unit;
        $this->storage_unit = $inventoryTransaction->inventoryItem->storage_unit;
        $this->ingredient_unit = $inventoryTransaction->inventoryItem->ingredient_unit;
    }

    public function addToInventory()
    {
        if ($this->inventoryItem->quantity != 0) {
            return $this->dispatchBrowserEvent('swal', [
                'title' => __('Inventory Item qunatity is not 0.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);
        }

        $this->inventoryTransaction->status = 'completed';
        $this->inventoryTransaction->save();

        $this->inventoryItem->update([
            'quantity' => $this->inventoryTransaction->ingredient_quantity,
            'expiration_date' => $this->inventoryTransaction->expiration_date
        ]);

        session()->flash('alert', __('Added Successfully.'));
    }

    public function render()
    {
        return view('livewire.dashboard.inventory-transactions.show', [
            'suppliers' => Supplier::restaurant()->get(),
            'inventoryItems' => InventoryItem::restaurant()->get()
        ]);
    }
}
