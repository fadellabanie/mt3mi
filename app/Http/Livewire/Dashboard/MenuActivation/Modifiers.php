<?php

namespace App\Http\Livewire\Dashboard\MenuActivation;

use App\Models\Modifier;
use Livewire\Component;

class Modifiers extends Component
{
    public $selectedModifiers = [];

    public function submit()
    {

        Modifier::restaurant()->whereIn('id', $this->selectedModifiers)->update([
            'is_active' => true
        ]);

        Modifier::restaurant()->whereNotIn('id', $this->selectedModifiers)->update([
            'is_active' => false
        ]);

        $this->dispatchBrowserEvent('swal', [
            'title' => __('Saved Successfully.'),
            'icon' => 'success',
            'showConfirmButton' => true
        ]);
    }

    public function mount()
    {
        $this->selectedModifiers = Modifier::active()->pluck('id')->map(function ($id) {
            return (string) $id;
        })->all();
    }

    public function render()
    {
        return view('livewire.dashboard.menu-activation.modifiers', [
            'modifiers' => Modifier::restaurant()->get()
        ]);
    }
}
