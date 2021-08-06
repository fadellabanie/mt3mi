<?php

namespace App\Http\Livewire\Manage\Restaurants;

use Livewire\Component;
use App\Models\Restaurant;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Update extends Component
{
    use WithFileUploads;

    public $restaurant;
    public $user;
    public $password;
    public $attachments = [];
    public $selectedId;

    protected function rules()
    {
        return [
            'restaurant.name' => 'required|min:3|max:100',
            'user.name' => 'required|string|min:3|max:25',
            'user.email' => 'required|string|email|unique:users,email,' . $this->user->id,
            'user.dial_code' => 'required',
            'user.phone' => 'required|string|max:15|unique:users,phone,' . $this->user->id,
            'password' => 'nullable|min:8|max:64',
            'restaurant.subscription_end_date' => 'nullable|date',
            'restaurant.is_active' => 'boolean'
        ];
    }

    public function export($id)
    {
        $media = Media::find($id);

        return Storage::disk('public')->download($media->id . '/' . $media->file_name);
    }

    public function confirm($id)
    {
        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        $media = Media::find($this->selectedId);

        if (Storage::disk('public')->exists($media->id . '/' . $media->file_name)) {
            Storage::disk('public')->delete($media->id . '/' . $media->file_name);
        }

        $media->delete();

        return redirect()->route('manage.restaurants.edit', $this->restaurant);
    }

    public function submit()
    {
        $this->validate();

        $this->restaurant->save();

        if($this->password) {
            $this->user->password = Hash::make($this->password);
        }

        $this->user->save();

        $permissions = Role::where('name', 'owner')->first()->permissions()->pluck('id');

        $this->user->givePermissionTo($permissions);

        Artisan::call('optimize');

        collect($this->attachments)->each(fn ($attachment) =>
            $this->restaurant->addMedia($attachment->getRealPath())->toMediaCollection('attachments')
        );

        session()->flash('alert', __('Saved Successfully.'));

        return redirect()->route('manage.restaurants.index');
    }

    public function mount(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
        $this->user = $restaurant->owner;
    }

    public function render()
    {
        return view('livewire.manage.restaurants.update', [
            'restaurantAttachments' => $this->restaurant->getMedia('attachments')
        ]);
    }
}
