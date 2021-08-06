<?php

namespace App\Http\Livewire\Dashboard\Tags;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name_ar;
    public $name_en;
    public $icon;

    protected $rules = [
        'name_ar' => 'required|string|min:3|max:25',
        'name_en' => 'required|string|min:3|max:25',
        'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
    ];

    public function updatedIcon()
    {
        $this->validate([
            'icon' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
    }

    public function submit()
    {
        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;
        $validatedData['icon'] = ($this->icon) ? $this->icon->store('tags', 'public') : '';

        Tag::create($validatedData);

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
        return view('livewire.dashboard.tags.create');
    }
}
