<?php

namespace App\Http\Livewire\Dashboard\Categories;

use Livewire\Component;
use App\Models\Category;
use App\Models\TimedEvent;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name_ar;
    public $name_en;
    public $sku;
    public $icon;
    public $categoryTimedEvents = [];

    protected $rules = [
        'name_ar' => 'required|string|min:3|max:25',
        'name_en' => 'required|string|min:3|max:25',
        'sku' => 'required|string|min:3|max:25',
        'icon' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
    ];

    public function updatedIcon()
    {
        $this->validate([
            'icon' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
    }

    public function submit()
    {
        $position = Category::restaurant()->max('position') + 1;

        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;
        $validatedData['icon'] = ($this->icon) ? $this->icon->store('categories', 'public') : '';
        $validatedData['position'] = $position;

        $category = Category::create($validatedData);

        $category->timedEvents()->attach($this->categoryTimedEvents);

        $this->reset();

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.dashboard.categories.create', [
            'timedEvents' => TimedEvent::restaurant()->get()
        ]);
    }
}
