<?php

namespace App\Http\Livewire\Dashboard\ProductModifiers;

use App\Models\Product;
use Livewire\Component;
use App\Models\Modifier;
use App\Models\ProductModifier;

class Update extends Component
{
    public $product;
    public $productModifiers;
    public $name = '';
    public $modifier;
    public $minimum_options = 0;
    public $maximum_options = 100;
    public $selectedModifier;
    public $action;

    protected $listeners = ['triggerRefresh' => '$refresh'];

    public function create()
    {
        $this->reset([
            'modifier',
            'minimum_options',
            'maximum_options'
        ]);

        $this->resetForm();

        $this->dispatchBrowserEvent('show-create-modifier-modal');
    }

    public function store()
    {
        $this->validate([
            'modifier' => 'required',
            'minimum_options' => 'required|numeric',
            'maximum_options' => 'required|numeric'
        ]);

        if (!is_null(ProductModifier::where([
            ['product_id', '=', $this->product->id],
            ['modifier_id', '=', $this->modifier]
        ])->first())) {
            $this->dispatchBrowserEvent('swal', [
                'title' => __('Modifier already exists.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);

            return;
        }

        ProductModifier::create([
            'product_id' => $this->product->id,
            'modifier_id' => $this->modifier,
            'minimum_options' => $this->minimum_options,
            'maximum_options' => $this->maximum_options,
        ]);

        $this->productModifiers = ProductModifier::with(['modifier'])
        ->where('product_id', $this->product->id)->get();

        $this->emit('triggerRefresh');

        $this->dispatchBrowserEvent('hide-create-modifier-modal');
    }

    public function selectModifier($modifierId, $action)
    {
        $this->selectedModifier = $modifierId;

        if ($action == 'delete') {
            $this->delete();
        } else {
            $modifierItem = ProductModifier::where('id', $this->selectedModifier)->first();

            $this->name = $modifierItem->modifier->name;
            $this->modifier = $modifierItem->modifier_id;
            $this->minimum_options = $modifierItem->minimum_options;
            $this->maximum_options = $modifierItem->maximum_options;

            $this->resetForm();

            $this->dispatchBrowserEvent('show-edit-modifier-modal');
        }
    }

    public function update()
    {
        $this->validate([
            'minimum_options' => 'required|numeric',
            'maximum_options' => 'required|numeric'
        ]);

        ProductModifier::where('id', $this->selectedModifier)->update([
            'minimum_options' => $this->minimum_options,
            'maximum_options' => $this->maximum_options,
        ]);

        $this->emit('triggerRefresh');

        $this->dispatchBrowserEvent('hide-edit-modifier-modal');
    }

    public function delete()
    {
        ProductModifier::where('id', $this->selectedModifier)->delete();

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
        $this->productModifiers = ProductModifier::with(['modifier'])
            ->where('product_id', $product->id)->get();
    }

    public function render()
    {
        return view('livewire.dashboard.product-modifiers.update.datatable', [
            'modifiers' => Modifier::restaurant()->get()
        ]);
    }
}
