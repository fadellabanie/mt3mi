<?php

namespace App\Http\Livewire\Dashboard\ProductModifiers;

use Livewire\Component;
use App\Models\Modifier;

class Create extends Component
{
    public $productModifiers;
    public $name = '';
    public $modifier;
    public $minimum_options = 0;
    public $maximum_options = 100;
    public $selectedModifier;
    public $action;

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

        if (!is_null($this->productModifiers->where('id', $this->modifier)->first())) {
            $this->dispatchBrowserEvent('swal', [
                'title' => __('Modifier already exists.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);

            return;
        }

        $modifierItem = Modifier::where('id', $this->modifier)->first();

        $this->productModifiers->push([
            'uid' => time(),
            'id' => $modifierItem->id,
            'name' => $modifierItem->name,
            'minimum_options' => $this->minimum_options,
            'maximum_options' => $this->maximum_options
        ]);

        $this->emit('modifierUpdated', $this->productModifiers);
        $this->dispatchBrowserEvent('modifierUpdated');

        $this->reset([
            'name',
            'modifier',
            'minimum_options',
            'maximum_options'
        ]);

        $this->dispatchBrowserEvent('hide-create-modifier-modal');
    }

    public function selectModifier($modifierId, $action)
    {
        $this->selectedModifier = $modifierId;

        if ($action == 'delete') {
            $this->delete();
        } else {
            $modifierItem = $this->productModifiers->where('id', $this->selectedModifier)->first();

            $this->name = $modifierItem['name'];
            $this->modifier = $modifierItem['id'];
            $this->minimum_options = $modifierItem['minimum_options'];
            $this->maximum_options = $modifierItem['maximum_options'];

            $this->resetForm();

            $this->dispatchBrowserEvent('show-edit-modifier-modal');
        }
    }

    public function update()
    {
        $this->validate([
            'modifier' => 'required',
            'minimum_options' => 'required|numeric',
            'maximum_options' => 'required|numeric'
        ]);

        $modifierItem = $this->productModifiers->where('id', $this->selectedModifier)->first();

        $this->productModifiers = $this->productModifiers->keyBy('id');

        $this->productModifiers->forget($this->selectedModifier);

        $this->productModifiers->push([
            'uid' =>  $modifierItem['uid'],
            'id' => $modifierItem['id'],
            'name' => $modifierItem['name'],
            'minimum_options' => $this->minimum_options,
            'maximum_options' => $this->maximum_options
        ]);

        $this->emit('modifierUpdated', $this->productModifiers);
        $this->dispatchBrowserEvent('modifierUpdated');

        $this->dispatchBrowserEvent('hide-edit-modifier-modal');
    }

    public function delete()
    {
        $this->productModifiers = $this->productModifiers->keyBy('id');

        $this->productModifiers->forget($this->selectedModifier);

        $this->emit('modifierUpdated', $this->productModifiers);
        $this->dispatchBrowserEvent('modifierUpdated');
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function mount()
    {
        $this->productModifiers = collect();
    }

    public function render()
    {
        return view('livewire.dashboard.product-modifiers.create.datatable', [
            'modifiers' => Modifier::restaurant()->get()
        ]);
    }
}
