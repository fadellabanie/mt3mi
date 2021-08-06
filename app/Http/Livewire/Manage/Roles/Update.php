<?php

namespace App\Http\Livewire\Manage\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Update extends Component
{
    public Role $role;
    public $name;
    public $selectedPermission;

    protected $rules = [
        'name' => 'required|string|min:3|max:50'
    ];

    public function createPermission()
    {
        $this->reset([
            'name',
        ]);

        $this->resetForm();

        $this->dispatchBrowserEvent('show-create-permission-modal');
    }

    public function storePermission()
    {
        $this->validate();

        $permission = Permission::create([
            'name' => $this->name
        ]);

        $this->role->givePermissionTo($permission);

        $this->dispatchBrowserEvent('swal', [
            'title' => __('Saved Successfully.'),
            'icon' => 'success',
            'showConfirmButton' => true
        ]);

        $this->dispatchBrowserEvent('hide-create-permission-modal');
    }

    public function editPermission($id)
    {
        $this->selectedPermission = $id;

        $permission = Permission::where('id', $this->selectedPermission)->first();

        $this->name = $permission->name;

        $this->resetForm();

        $this->dispatchBrowserEvent('show-edit-permission-modal');
    }

    public function updatePermission()
    {
        $this->validate();

        Permission::where('id', $this->selectedPermission)->update([
            'name' => $this->name
        ]);

        $this->dispatchBrowserEvent('swal', [
            'title' => __('Saved Successfully.'),
            'icon' => 'success',
            'showConfirmButton' => true
        ]);

        $this->dispatchBrowserEvent('hide-edit-permission-modal');
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.manage.roles.update', [
            'role' => $this->role,
            'permissions' => $this->role->permissions()->paginate()
        ]);
    }
}
