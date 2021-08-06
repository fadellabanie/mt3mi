<?php

namespace App\Http\Livewire\Dashboard\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required|string|min:3|max:50'
    ];

    public function submit()
    {
        $role = Role::create($this->validate());

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
        return view('livewire.dashboard.roles.create');
    }
}
