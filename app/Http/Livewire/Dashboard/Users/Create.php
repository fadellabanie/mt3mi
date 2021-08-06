<?php

namespace App\Http\Livewire\Dashboard\Users;

use App\Models\User;
use Livewire\Component;
use App\Traits\WithHoney;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

class Create extends Component
{
    //use WithHoney;

    public $permissions = [];
    public $rolePermissions = [];
    public $name;
    public $type = 'owner';
    public $dial_code = '+966';
    public $phone;
    public $email;
    public $employee_number;
    public $username;
    public $password;
    public $language;
    public $salary;
    public $business_role;
    public $pin_code;

    protected $rules = [
        'name' => 'required|string|max:25',
        'type' => 'required',
        'dial_code' => 'required',
        'phone' => ['required', 'max:15'],
        'email' => 'nullable|string|email|max:255|required_unless:type,app user',
        'employee_number' => 'nullable',
        'username' => 'nullable|string|alpha_dash|required_if:type,app user',
        'password' => 'nullable|string|min:8|required_unless:type,app user',
        'language' => 'nullable',
        'salary' => 'nullable|numeric',
        'business_role' => 'nullable|string|min:3|max:25',
        'pin_code' => 'nullable|string|max:4|required_if:type,app user',
    ];

    public function updatedPhone()
    {
        if (!is_null(User::restaurant()->where('phone', $this->phone)->first())) {
            return $this->addError('phone', __('Phone already exists.'));
        }
    }

    public function updatedEmail()
    {
        if (!is_null(User::where('email', $this->email)->first())) {
            return $this->addError('email', __('Email already exists.'));
        }
    }

    public function updatedUsername()
    {
        if (!is_null(User::restaurant()->where('username', $this->username)->first())) {
            return $this->addError('username', __('Username already exists.'));
        }
    }

    public function updatedType()
    {
        $role = \Spatie\Permission\Models\Role::whereName($this->type)->first();

        $this->permissions = $role->permissions->isNotEmpty() ? $role->permissions->toArray() : [];
    }

    public function submit()
    {
        //$this->honeyPasses();

        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;
        $validatedData['language'] = ($this->language) ? $this->language : 'ar';
        $validatedData['email'] = ($this->type != 'app user') ? $this->email : '';
        $validatedData['employee_number'] = ($this->type == 'app user') ? $this->employee_number : '';
        $validatedData['username'] = ($this->type == 'app user') ? $this->username : '';
        $validatedData['password'] = Hash::make($this->password);

        if ($this->type == 'app user') {
            $validatedData['password'] = Hash::make($this->pin_code);
        }

        $user = User::create($validatedData);

        //$user->assignRole($this->type);

        //if ($this->type != 'owner') {
            $user->givePermissionTo($this->rolePermissions);
        //} else {
           // $permissions = Permission::get()->pluck('name');
           // $user->givePermissionTo($permissions);
        //}

        Artisan::call('optimize');

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
        return view('livewire.dashboard.users.create');
    }
}
