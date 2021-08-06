<?php

namespace App\Http\Livewire\Dashboard\Suppliers;

use Livewire\Component;
use App\Models\Supplier;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\SupplierExport;
use App\Imports\SupplierImport;
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
    public $onlyTrashed = false;

    protected $rules = [
        'import' => 'required',
    ];
    public function confirm($id)
    {
        $this->authorize('Delete Suppliers');

        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        Supplier::findOrFail($this->selectedId)->delete();
    }

    public function restore($id)
    {
        $row = Supplier::whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = Supplier::whereId($id)->withTrashed()->first();
        $row->forceDelete();
    }

    public function export()
    {
        $this->authorize('Export Suppliers');

        return Excel::download(new SupplierExport, 'suppliers.xlsx');
    }
    public function import()
    {
        $this->authorize('Import Suppliers');

        try {
            $validatedData = $this->validate();
            Excel::import(new SupplierImport, $validatedData['import']);
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
            return view('livewire.dashboard.suppliers.datatable', [
                'suppliers' => Supplier::restaurant()->onlyTrashed()->paginate()
            ]);
        }
        return view('livewire.dashboard.suppliers.datatable', [
            'suppliers' => Supplier::restaurant()->paginate()
        ]);
    }
}
