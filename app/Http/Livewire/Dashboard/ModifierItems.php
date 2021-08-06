<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\InventoryItem;
use App\Models\Modifier;
use App\Models\ModifierItem;
use Livewire\Component;

class ModifierItems extends Component
{
    public $name = '';
    public $modifier;
    public $modifierItems;
    public $inventory_item_id;
    public $quantity = 0;
    public $unit = '';
    public $selectedModifierItem;
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
            'unit'
        ]);

        $this->resetForm();

        $this->dispatchBrowserEvent('show-create-item-modal');
    }

    public function store()
    {
        $this->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'quantity' => 'required|numeric|min:0'
        ]);

        if (!is_null(ModifierItem::where([
            ['modifier_id', '=', $this->modifier->id],
            ['inventory_item_id', '=', $this->inventory_item_id]
        ])->first())) {
            $this->dispatchBrowserEvent('swal', [
                'title' => __('Ingredient already exists.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);

            return;
        }

        ModifierItem::create([
            'modifier_id' => $this->modifier->id,
            'inventory_item_id' => $this->inventory_item_id,
            'quantity' => $this->quantity
        ]);

        $this->modifierItems = $this->modifier->modifierItems()->with(['inventoryItem'])->get();

        $this->dispatchBrowserEvent('hide-create-item-modal');
    }

    public function selectItem($modifierItemId, $action)
    {
        $this->selectedModifierItem = $modifierItemId;

        if ($action == 'delete') {
            $this->delete();
        } else {
            $modifierItem  = ModifierItem::where('id', $this->selectedModifierItem)->first();

            $inventroyItem = InventoryItem::where('id', $modifierItem->inventory_item_id)->first();

            $this->name = $inventroyItem->name;

            $this->unit = $inventroyItem->ingredient_unit;

            $this->quantity = $modifierItem->quantity;

            $this->resetForm();

            $this->dispatchBrowserEvent('show-edit-item-modal');
        }
    }

    public function update()
    {
        $this->validate([
            'quantity' => 'required|numeric|min:0'
        ]);

        ModifierItem::where('id', $this->selectedModifierItem)->update([
            'quantity' => $this->quantity
        ]);

        $this->dispatchBrowserEvent('hide-edit-item-modal');
    }

    public function delete()
    {
        ModifierItem::where('id', $this->selectedModifierItem)->delete();

        $this->emit('triggerRefresh');
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function mount(Modifier $modifier)
    {
        $this->modifier = $modifier;
        $this->modifierItems = $modifier->modifierItems()->with(['inventoryItem'])->get();
    }

    public function render()
    {
        return view('livewire.dashboard.modifier-items.datatable', [
            'inventoryItems' => InventoryItem::all()
        ]);
    }
}
