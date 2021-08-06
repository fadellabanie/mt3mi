<?php

namespace App\Http\Livewire\Dashboard\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class Update extends Component
{
    public $user;
    public $password;
    public $rolePermissions;
    public $permissions;
    public $type;

    protected $rules = [
        'user.name' => 'required|string|max:255',
        //'user.type' => 'required',
        'user.dial_code' => 'required',
        'user.phone' => ['required', 'max:15'],
        'user.email' => 'nullable|string|email|max:255|required_unless:type,app user',
        'user.employee_number' => 'nullable',
        'user.username' => 'nullable|string|alpha_dash|required_if:type,app user',
        'user.language' => 'nullable',
        'user.salary' => 'nullable',
        'user.business_role' => 'nullable',
        'user.pin_code' => 'nullable|string|max:4|required_if:type,app user',
    ];

    public function updatedPassword()
    {
        $this->validate([
            'password' => 'string|min:8',
        ]);
    }

    public function mount(User $user)
    {
        $this->user = $user;

        $this->type = $user->type;

        $role = \Spatie\Permission\Models\Role::whereName($this->type)->first();

        $this->permissions = $role->permissions->isNotEmpty() ? $role->permissions->toArray() : [];

        $this->rolePermissions = $user->permissions->pluck('id')->all();
    }

    public function submit()
    {
        $this->validate();

        if ($this->user->type == 'app user') {
            $this->user->password = Hash::make($this->user->pin_code);
        }

        $this->user->save();

        if ($this->password) {
            $this->user->update([
                'password' => Hash::make($this->password)
            ]);
        }

        //$this->user->syncRoles([$this->user->type]);

        $this->user->syncPermissions($this->rolePermissions);

        Artisan::call('optimize');

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function render()
    {
        return view('livewire.dashboard.users.update');
    }
}
