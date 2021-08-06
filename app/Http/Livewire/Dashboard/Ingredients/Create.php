<?php

namespace App\Http\Livewire\Dashboard\Ingredients;

use Livewire\Component;
use App\Models\InventoryItem;

class Create extends Component
{
    public $ingredients;
    public $name = '';
    public $ingredient;
    public $quantity = 1;
    public $selectedIngredient;
    public $action;

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

        if (!is_null($this->ingredients->where('id', $this->ingredient)->first())) {
            $this->dispatchBrowserEvent('swal', [
                'title' => __('Ingredient already exists.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);

            return;
        }

        $item = InventoryItem::where('id', $this->ingredient)->first();

        $this->ingredients->push([
            'uid' => time(),
            'id' => $item->id,
            'name' => $item->name,
            'quantity' => $this->quantity
        ]);

        $this->emit('ingredientUpdated', $this->ingredients);
        $this->dispatchBrowserEvent('ingredientUpdated');

        $this->reset([
            'name',
            'ingredient',
            'quantity'
        ]);

        $this->dispatchBrowserEvent('hide-create-ingredient-modal');
    }

    public function selectIngredient($ingredientId, $action)
    {
        $this->selectedIngredient = $ingredientId;

        if ($action == 'delete') {
            $this->delete();
        } else {
            $ingredientItem = $this->ingredients->where('id', $this->selectedIngredient)->first();

            $this->name = $ingredientItem['name'];
            $this->ingredient = $ingredientItem['id'];
            $this->quantity = $ingredientItem['quantity'];

            $this->resetForm();

            $this->dispatchBrowserEvent('show-edit-ingredient-modal');
        }
    }

    public function update()
    {
        $this->validate([
            'quantity' => 'required|numeric',
        ]);

        $ingredientItem = $this->ingredients->where('id', $this->selectedIngredient)->first();

        $this->ingredients = $this->ingredients->keyBy('id');

        $this->ingredients->forget($this->selectedIngredient);

        $this->ingredients->push([
            'uid' =>  $ingredientItem['uid'],
            'id' => $ingredientItem['id'],
            'name' => $ingredientItem['name'],
            'quantity' => $this->quantity
        ]);

        $this->emit('ingredientUpdated', $this->ingredients);
        $this->dispatchBrowserEvent('ingredientUpdated');

        $this->dispatchBrowserEvent('hide-edit-ingredient-modal');
    }

    public function delete()
    {
        $this->ingredients = $this->ingredients->keyBy('id');

        $this->ingredients->forget($this->selectedIngredient);

        $this->emit('ingredientUpdated', $this->ingredients);
        $this->dispatchBrowserEvent('ingredientUpdated');
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function mount()
    {
        $this->ingredients = collect();
    }

    public function render()
    {
        return view('livewire.dashboard.ingredients.create.datatable', [
            'items' => InventoryItem::restaurant()->get()
        ]);
    }
}
