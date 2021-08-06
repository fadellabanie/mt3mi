<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Honey extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div style="display: none;">
    <input type="text"
            name="hg_name"
            id="hg_name"
            wire:model.defer="hg_name"
    >
    <input type="text"
            name="hg_time"
            id="hg_time"
            wire:model.defer="hg_time"
            required
    >
</div>
blade;
    }
}
