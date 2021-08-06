<?php

namespace App\Http\Livewire\Dashboard\MenuActivation;

use App\Models\Category;
use Livewire\Component;

class Categories extends Component
{
    public $selectedCategories = [];

    public function submit()
    {

        Category::restaurant()->whereIn('id', $this->selectedCategories)->update([
            'is_active' => true
        ]);

        Category::restaurant()->whereNotIn('id', $this->selectedCategories)->update([
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
        $this->selectedCategories = Category::active()->pluck('id')->map(function ($id) {
            return (string) $id;
        })->all();
    }

    public function render()
    {
        return view('livewire.dashboard.menu-activation.categories', [
            'categories' => Category::restaurant()->get()
        ]);
    }
}
