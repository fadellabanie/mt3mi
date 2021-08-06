<?php

namespace App\Http\Livewire\Dashboard\Tags;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $tag;
    public $upload;

    protected $rules = [
        'tag.name_ar' => 'required|string|min:3|max:25',
        'tag.name_en' => 'required|string|min:3|max:25',
        'tag.icon' => 'nullable',
    ];

    public function updatedUpload()
    {
        $this->validate([
            'upload' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
    }

    public function submit()
    {
        $this->validate();

        $this->tag->save();

        if ($this->upload) {
            $this->tag->update([
                'icon' => $this->upload->store('tags', 'public')
            ]);
        }

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function mount(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function render()
    {
        return view('livewire.dashboard.tags.update');
    }
}
