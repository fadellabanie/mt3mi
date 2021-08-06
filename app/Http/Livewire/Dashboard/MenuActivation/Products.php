<?php

namespace App\Http\Livewire\Dashboard\MenuActivation;

use App\Models\Product;
use Livewire\Component;

class Products extends Component
{
    public $selectedProducts = [];

    public function submit()
    {

        Product::restaurant()->whereIn('id', $this->selectedProducts)->update([
            'is_active' => true
        ]);

        Product::restaurant()->whereNotIn('id', $this->selectedProducts)->update([
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
        $this->selectedProducts = Product::active()->pluck('id')->map(function ($id) {
            return (string) $id;
        })->all();
    }

    public function render()
    {
        return view('livewire.dashboard.menu-activation.products', [
            'products' => Product::restaurant()->get()
        ]);
    }
}
