<?php

namespace App\Http\Livewire\Dashboard\Modifiers;

use Livewire\Component;
use App\Models\Modifier;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\ModifierExport;
use App\Imports\ModifierImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Datatable extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public $import;
    public $onlyTrashed = false;

    protected $rules = [
        'import' => 'required',
    ];
    protected $paginationTheme = 'bootstrap';
    public $selectedId;

    public function confirm($id)
    {
        $this->authorize('delete Add ons');

        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        Modifier::restaurant()->findOrFail($this->selectedId)->delete();
    }
    public function restore($id)
    {
        $row = Modifier::restaurant()->whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = Modifier::with('products')->restaurant()->whereId($id)->withTrashed()->first();
     
        if (!$row->products()->exists()) {
            $row->forceDelete();
        }

        $row->forceDelete();
    }
    public function export()
    {
        $this->authorize('Export Add ons');

        return Excel::download(new ModifierExport, 'modifiers.xlsx');
    }
    public function import()
    {
        $this->authorize('Import Add ons');

        try {
            $validatedData = $this->validate();
            Excel::import(new ModifierImport, $validatedData['import']);
            session()->flash('alert', __('Saved Successfully.'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $th) {
            foreach ($th->errors() as $key => $error) {
                session()->flash('alert', $error);
            }
        }
    }
    public function render()
    {
        if ($this->onlyTrashed) {
            return view('livewire.dashboard.modifiers.datatable', [
                'modifiers' => Modifier::withCount(['modifierOptions', 'products'])->restaurant()->onlyTrashed()->paginate()
            ]);
        }

        return view('livewire.dashboard.modifiers.datatable', [
            'modifiers' => Modifier::withCount(['modifierOptions', 'products'])->restaurant()->paginate()
        ]);
    }
}
