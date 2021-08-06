<?php

namespace App\Http\Livewire\Dashboard\InventoryItems;

use App\Models\InventoryItem;
use App\Models\Tag;
use Livewire\Component;

class Create extends Component
{
    public $name_ar;
    public $name_en;
    public $type;
    public $sku;
    public $barcode;
    public $purchase_unit;
    public $storage_unit;
    public $ingredient_unit;
    public $purchase_to_storage_factor;
    public $storage_to_ingredient_factor;
    public $cost_type = 'variable';
    public $cost;
    public $minimum_level_alert;
    public $itemTags = [];
    public $ingredients;

    protected $listeners = ['ingredientUpdated'];

    protected $rules = [
        'name_ar' => 'required|string|min:3|max:25',
        'name_en' => 'required|string|min:3|max:25',
        'type' => 'required',
        'sku' => 'nullable|string',
        'barcode' => 'nullable|string',
        'purchase_unit' => 'required|string',
        'storage_unit' => 'required|string',
        'ingredient_unit' => 'required|string',
        'purchase_to_storage_factor' => 'required|numeric',
        'storage_to_ingredient_factor' => 'required|numeric',
        'cost_type' => 'required',
        'cost' => 'nullable|numeric|required_if:cost_type,fixed',
        'minimum_level_alert' => 'required|numeric',
        'itemTags' => 'nullable|array',
    ];

    public function ingredientUpdated($ingredients)
    {
        $this->ingredients = $ingredients;
    }

    public function submit()
    {
        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;

        $validatedData['cost'] = ($this->cost_type == 'fixed') ? $this->cost : 0;

        $inventoryItem = InventoryItem::create($validatedData);

        $inventoryItem->tags()->attach($this->itemTags);

        if (! is_null($this->ingredients)) {
            foreach ($this->ingredients as $ingredient) {
                $inventoryItem->ingredients()->create([
                    'ingredient_id' => $ingredient['id'],
                    'quantity' => $ingredient['quantity'],
                ]);
            }
        }

        session()->flash('alert', __('Saved Successfully.'));

        return redirect()->route('dashboard.inventory-items.index');
    }

    public function render()
    {
        return view('livewire.dashboard.inventory-items.create', [
            'tags' => Tag::restaurant()->active()->get(),
            'items' => InventoryItem::restaurant()->get(),
        ]);
    }
}
