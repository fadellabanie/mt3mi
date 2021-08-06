<?php

namespace App\Http\Livewire\Dashboard\InventoryItems;

use App\Models\Tag;
use Livewire\Component;
use App\Models\InventoryItem;

class Update extends Component
{
    public $inventoryItem;
    public $itemTags;

    protected $rules = [
        'inventoryItem.name_ar' => 'required|string|min:3|max:25',
        'inventoryItem.name_en' => 'required|string|min:3|max:25',
        'inventoryItem.type' => 'required',
        'inventoryItem.sku' => 'nullable|string',
        'inventoryItem.barcode' => 'nullable|string',
        'inventoryItem.purchase_unit' => 'required|string',
        'inventoryItem.storage_unit' => 'required|string',
        'inventoryItem.ingredient_unit' => 'required|string',
        'inventoryItem.purchase_to_storage_factor' => 'required|numeric',
        'inventoryItem.storage_to_ingredient_factor' => 'required|numeric',
        'inventoryItem.cost_type' => 'required',
        'inventoryItem.cost' => 'nullable|numeric|required_if:cost_type,fixed',
        'inventoryItem.minimum_level_alert' => 'required|numeric',
        'itemTags' => 'nullable|array',
    ];

    public function submit()
    {
        $this->validate();

        $this->inventoryItem->cost = ($this->inventoryItem->cost_type == 'fixed') ? $this->inventoryItem->cost : 0;

        $this->inventoryItem->save();

        $this->inventoryItem->tags()->sync($this->itemTags);

        session()->flash('alert', __('Saved Successfully.'));

        return redirect()->route('dashboard.inventory-items.index');
    }

    public function mount(InventoryItem $inventoryItem)
    {
        $this->inventoryItem = $inventoryItem;
        $this->itemTags = $inventoryItem->tags()->pluck('tag_id')->all();
    }

    public function render()
    {
        return view('livewire.dashboard.inventory-items.update', [
            'tags' => Tag::restaurant()->active()->get(),
            'items' => InventoryItem::restaurant()->get(),
        ]);
    }
}
