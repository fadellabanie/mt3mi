<?php

namespace App\Http\Livewire\Dashboard\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Datatable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $selectedId;

    public function confirm($id)
    {
        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        Role::findOrFail($this->selectedId)->delete();
    }
    
    public function render()
    {
        return view('livewire.dashboard.roles.datatable', [
            'roles' => Role::paginate()
        ]);
    }
}
