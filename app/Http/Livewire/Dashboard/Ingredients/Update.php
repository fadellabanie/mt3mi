<?php

namespace App\Http\Livewire\Dashboard\Ingredients;

use App\Models\InventoryItem;
use App\Models\InventoryItemIngredient;
use Livewire\Component;

class Update extends Component
{
    public $inventoryItem;
    public $inventoryItemIngredients;
    public $name = '';
    public $ingredient;
    public $quantity = 1;
    public $selectedIngredient;
    public $action;

    protected $listeners = ['triggerRefresh' => '$refresh'];

    public function create()
    {
        $this->reset([
            'ingredient',
            'quantity'
        ]);

        $this->resetForm();

        $this->dispatchBrowserEvent('show-create-ingredient-modal');
    }

    public function store()
    {
        $this->validate([
            'ingredient' => 'required',
            'quantity' => 'required|numeric',
        ]);

        if (!is_null(InventoryItemIngredient::where([
            ['inventory_item_id', '=', $this->inventoryItem->id],
            ['ingredient_id', '=', $this->ingredient]
        ])->first())) {
            $this->dispatchBrowserEvent('swal', [
                'title' => __('Ingredient already exists.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);

            return;
        }

        InventoryItemIngredient::create([
            'inventory_item_id' => $this->inventoryItem->id,
            'ingredient_id' => $this->ingredient,
            'quantity' => $this->quantity
        ]);

        $this->inventoryItemIngredients = InventoryItemIngredient::with(['ingredient'])
        ->where('inventory_item_id', $this->inventoryItem->id)->get();

        $this->emit('triggerRefresh');

        $this->dispatchBrowserEvent('hide-create-ingredient-modal');
    }

    public function selectIngredient($ingredientId, $action)
    {
        $this->selectedIngredient = $ingredientId;

        if ($action == 'delete') {
            $this->delete();
        } else {
            $ingredientItem = InventoryItemIngredient::where('id', $this->selectedIngredient)->first();

            $this->name = $ingredientItem->ingredient->name;
            $this->ingredient = $ingredientItem->ingredient_id;
            $this->quantity = $ingredientItem->quantity;

            $this->resetForm();

            $this->dispatchBrowserEvent('show-edit-ingredient-modal');
        }
    }

    public function update()
    {
        $this->validate([
            'quantity' => 'required|numeric',
        ]);

        InventoryItemIngredient::where('id', $this->selectedIngredient)->update([
            'quantity' => $this->quantity
        ]);

        $this->emit('triggerRefresh');

        $this->dispatchBrowserEvent('hide-edit-ingredient-modal');
    }

    public function delete()
    {
        InventoryItemIngredient::where('id', $this->selectedIngredient)->delete();

        $this->emit('triggerRefresh');
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function mount(InventoryItem $inventoryItem)
    {
        $this->inventoryItem = $inventoryItem;
        $this->inventoryItemIngredients = InventoryItemIngredient::with(['ingredient'])
            ->where('inventory_item_id', $inventoryItem->id)->get();
    }

    public function render()
    {
        return view('livewire.dashboard.ingredients.update.datatable', [
            'items' => InventoryItem::restaurant()->get()
        ]);
    }
}
