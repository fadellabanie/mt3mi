<?php

namespace App\Http\Livewire\Dashboard\MenuDisplay;

use App\Models\Tag;
use Livewire\Component;

class Tags extends Component
{
    public function submit()
    {

    }

    public function render()
    {
        return view('livewire.dashboard.menu-display.tags', [
            'tags' => Tag::with(['products' => function ($query) {
                $query->active();
            }])->active()->restaurant()->get()
        ]);
    }
}
