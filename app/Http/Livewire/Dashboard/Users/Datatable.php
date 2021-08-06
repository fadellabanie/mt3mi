<?php

namespace App\Http\Livewire\Dashboard\Users;

use App\Models\User;
use Livewire\Component;
use App\Exports\UserExport;
use App\Imports\UserImport;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Datatable extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';
    public $selectedId;
    public $import;

    protected $rules = [
        'import' => 'required',
    ];


    public function confirm($id)
    {
        $this->authorize('Delete employee');

        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        User::restaurant()->findOrFail($this->selectedId)->delete();
    }

    public function export()
    {
        $this->authorize('Delete employee');

        return Excel::download(new UserExport, 'users.xlsx');
    }

    public function import()
    {
        $this->authorize('Import employee');

        try {
            $validatedData = $this->validate();
            Excel::import(new UserImport, $validatedData['import']);
            session()->flash('alert', __('Saved Successfully.'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $th) {
            foreach ($th->errors() as $key => $error) {
                session()->flash('alert', $error);
            }
        }
    }

    public function render()
    {
        return view('livewire.dashboard.users.datatable', [
            'users' => User::restaurant()->paginate()
        ]);
    }
}
