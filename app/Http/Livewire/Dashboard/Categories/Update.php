<?php

namespace App\Http\Livewire\Dashboard\Categories;

use Livewire\Component;
use App\Models\Category;
use App\Models\TimedEvent;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $category;
    public $upload;
    public $categoryTimedEvents;

    protected $rules = [
        'category.name_ar' => 'required|string|min:3|max:25',
        'category.name_en' => 'required|string|min:3|max:25',
        'category.sku' => 'required|string|min:3|max:25',
        'category.icon' => 'nullable',
    ];

    public function updatedUpload()
    {
        $this->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
    }

    public function submit()
    {
        $this->validate();

        $this->category->save();

        if($this->upload) {
            $this->category->update([
                'icon' => $this->upload->store('categories', 'public')
            ]);
        }

        $this->category->timedEvents()->sync($this->categoryTimedEvents);

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->categoryTimedEvents = $category->timedEvents()->pluck('timed_event_id')->all();
    }

    public function render()
    {
        return view('livewire.dashboard.categories.update', [
            'timedEvents' => TimedEvent::restaurant()->get()
        ]);
    }
}
