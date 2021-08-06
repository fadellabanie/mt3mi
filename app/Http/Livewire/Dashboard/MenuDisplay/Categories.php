<?php

namespace App\Http\Livewire\Dashboard\MenuDisplay;

use App\Models\Category;
use Livewire\Component;

class Categories extends Component
{
    public function submit()
    {

    }

    /*public function updateCategoryOrder($categories)
    {
        foreach ($categories as $category) {
            Category::find($category['value'])->update(['position' => $category['order']]);
        }
    }*/

    public function sortUp($categoryId)
    {
        $category = Category::find($categoryId);

        Category::restaurant()->where('position', $category->position - 1)->update([
            'position' => $category->position
        ]);

        if ($category) {
            $category->update(['position' => $category->position - 1]);
        }
    }

    public function sortDown($categoryId)
    {
        $category = Category::find($categoryId);

        Category::restaurant()->where('position', $category->position + 1)->update([
            'position' => $category->position
        ]);

        if ($category) {
            $category->update(['position' => $category->position + 1]);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.menu-display.categories', [
            'categories' => Category::with(['products' => function ($query) {
                $query->active();
            }])->active()
            ->restaurant()
            ->orderBy('position')
            ->get()
        ]);
    }
}
