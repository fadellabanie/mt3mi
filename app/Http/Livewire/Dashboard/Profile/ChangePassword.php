<?php

namespace App\Http\Livewire\Dashboard\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePassword extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    protected $rules = [
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed',
    ];

    public function updatedCurrentPassword()
    {
        if (! Hash::check($this->current_password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => [ __('The current password is incorrect.') ],
            ]);
        }
    }

    public function submit()
    {
        if (!Hash::check($this->current_password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => [__('The current password is incorrect.')],
            ]);
        }
        
        $this->validate();

        auth()->user()->update([
            'password' => Hash::make($this->new_password)
        ]);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.dashboard.profile.change-password');
    }
}
