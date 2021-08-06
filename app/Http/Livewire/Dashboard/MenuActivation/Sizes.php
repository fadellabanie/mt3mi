<?php

namespace App\Http\Livewire\Dashboard\MenuActivation;

use Livewire\Component;
use App\Models\ProductSize;

class Sizes extends Component
{
    public $selectedSizes = [];

    public function submit()
    {

        ProductSize::restaurant()->whereIn('id', $this->selectedSizes)->update([
            'is_active' => true
        ]);

        ProductSize::restaurant()->whereNotIn('id', $this->selectedSizes)->update([
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
        $this->selectedSizes = ProductSize::active()->pluck('id')->map(function ($id) {
            return (string) $id;
        })->all();
    }

    public function render()
    {
        return view('livewire.dashboard.menu-activation.sizes', [
            'sizes' => ProductSize::restaurant()->get()
        ]);
    }
}
