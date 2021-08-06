<?php

namespace App\Http\Livewire\Dashboard\MenuActivation;

use App\Models\Tag;
use Livewire\Component;

class Tags extends Component
{
    public $selectedTags = [];

    public function submit()
    {

        Tag::restaurant()->whereIn('id', $this->selectedTags)->update([
            'is_active' => true
        ]);

        Tag::restaurant()->whereNotIn('id', $this->selectedTags)->update([
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
        $this->selectedTags = Tag::active()->pluck('id')->map(function ($id) {
            return (string) $id;
        })->all();
    }

    public function render()
    {
        return view('livewire.dashboard.menu-activation.tags', [
            'tags' => Tag::restaurant()->get()
        ]);
    }
}
