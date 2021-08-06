<?php

namespace App\Http\Livewire\Dashboard\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Update extends Component
{
    public $role;

    protected $rules = [
        'role.name' => 'required|string|min:3|max:50'
    ];

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function submit()
    {
        $this->validate();

        $this->role->save();

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function render()
    {
        return view('livewire.dashboard.roles.update');
    }
}
