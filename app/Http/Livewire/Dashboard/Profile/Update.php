<?php

namespace App\Http\Livewire\Dashboard\Profile;

use App\Models\User;
use Livewire\Component;

class Update extends Component
{
    public User $user;

    protected $rules = [
        'user.name' => 'required|string|max:255',
        'user.dial_code' => 'required',
        'user.phone' => ['required', 'max:15'],
        'user.email' => 'required|string|email|max:255',
        'user.language' => 'required',
        'user.salary' => 'nullable',
        'user.business_role' => 'nullable'
    ];

    public function submit()
    {
        $this->validate();

        $this->user->save();

        app()->setLocale($this->user->language);

        session()->put('locale', $this->user->language);

        session()->flash('alert', __('Saved Successfully.'));

        return redirect()->route('dashboard.profile.index');
    }

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.dashboard.profile.update');
    }
}
