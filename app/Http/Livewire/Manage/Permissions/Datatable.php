<?php

namespace App\Http\Livewire\Manage\Permissions;

use Artisan;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Datatable extends Component
{
    public $name;
    public $permissionRoles = [];
    public $selectedPermission;
    public $rolesFilter = 'all';

    public function create()
    {
        $this->reset([
            'name',
        ]);

        $this->resetForm();

        $this->dispatchBrowserEvent('show-create-permission-modal');
    }

    public function store()
    {
        $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:50', Rule::unique('permissions', 'name')],
            'permissionRoles' => 'array|required',
            'permissionRoles.*' => [Rule::exists('roles', 'id')],
        ]);

        $permission = Permission::create([
            'name' => $this->name
        ]);

        $permission->roles()->attach($this->permissionRoles);

        Artisan::call('optimize');

        $this->dispatchBrowserEvent('swal', [
            'title' => __('Saved Successfully.'),
            'icon' => 'success',
            'showConfirmButton' => true
        ]);

        $this->dispatchBrowserEvent('hide-create-permission-modal');
    }

    public function edit($id)
    {
        $this->selectedPermission = $id;

        $permission = Permission::where('id', $this->selectedPermission)->first();

        $this->name = $permission->name;

        $this->permissionRoles = $permission->roles()->pluck('role_id')->map(function ($role_id) {
            return (string) $role_id;
        })->all();

        $this->resetForm();

        $this->dispatchBrowserEvent('show-edit-permission-modal');
    }

    public function update()
    {
        $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:50', Rule::unique('permissions', 'name')->ignore($this->selectedPermission)],
            'permissionRoles' => 'array|required',
            'permissionRoles.*' => [Rule::exists('roles', 'id')],
        ]);

        $permission = Permission::where('id', $this->selectedPermission)->first();

        $permission->name = $this->name;
        $permission->save();

        $permission->roles()->sync($this->permissionRoles);

        Artisan::call('optimize');

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

    public function applyFilters()
    {
        $this->render();
    }


    public function render()
    {
        $permissions = Permission::query()
            ->when($this->rolesFilter && $this->rolesFilter !== 'all', function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('id', $this->rolesFilter);
                });
            })
            ->get();

        return view('livewire.manage.permissions.datatable', [
            'permissions' => $permissions,
            'roles' => Role::all(),
        ])->layout('layouts.admin');
    }
}
