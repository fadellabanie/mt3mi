<?php

namespace App\Http\Livewire\Manage\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Datatable extends Component
{
    public function render()
    {
        return view('livewire.manage.roles.datatable', [
            'roles' => Role::all()
        ]);
    }
}
