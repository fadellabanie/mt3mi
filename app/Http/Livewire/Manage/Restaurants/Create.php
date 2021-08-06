<?php

namespace App\Http\Livewire\Manage\Restaurants;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Restaurant;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $username;
    public $email;
    public $dial_code = '+966';
    public $phone;
    public $password;
    public $subscription_end_date;
    public $is_active = true;
    public $attachments = [];

    protected $rules = [
        'name' => 'required|min:3|max:100',
        'username' => 'required|string|min:3|max:25',
        'email' => 'required|string|email|unique:users,email',
        'dial_code' => 'required',
        'phone' => 'required|string|max:15|unique:users,phone',
        'password' => 'required|min:8|max:64',
        'subscription_end_date' => 'required|date|after_or_equal:today',
        'is_active' => 'boolean'
    ];

    public function submit()
    {
        $this->validate();

        $restaurant = Restaurant::create([
            'name' => $this->name,
            'registered_at' => Carbon::today(),
            'subscription_end_date' => Carbon::parse($this->subscription_end_date)
        ]);

        $user = User::create([
            'restaurant_id' => $restaurant->id,
            'name' => $this->username,
            'email' => $this->email,
            'dial_code' => $this->dial_code,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'type' => 'owner',
            'is_owner' => 1,
        ]);

        //$user->assignRole('owner');

        $permissions = Role::where('name', 'owner')->first()->permissions()->pluck('id');

        $user->givePermissionTo($permissions);

        Artisan::call('optimize');

        collect($this->attachments)->each(fn ($attachment) =>
            $restaurant->addMedia($attachment->getRealPath())->toMediaCollection('attachments')
        );

        session()->flash('alert', __('Saved Successfully.'));

        return redirect()->route('manage.restaurants.index');
    }

    public function render()
    {
        return view('livewire.manage.restaurants.create');
    }
}
