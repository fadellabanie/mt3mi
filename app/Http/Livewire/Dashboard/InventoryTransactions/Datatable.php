<?php

namespace App\Http\Livewire\Dashboard\InventoryTransactions;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\InventoryTransaction;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventoryTransactionExport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Imports\InventoryTransactions\InventoryTransactionImport;

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
        $this->authorize('Delete Inventory process');

        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        InventoryTransaction::restaurant()->findOrFail($this->selectedId)->delete();
    }
    public function restore($id)
    {
        $row = InventoryTransaction::whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = InventoryTransaction::whereId($id)->withTrashed()->first();
        $row->forceDelete();
    }
    public function export()
    {
        $this->authorize('Export Inventory process');

        return Excel::download(new InventoryTransactionExport, 'inventory-transactions.xlsx');
    }
    public function import()
    {
        $this->authorize('Import Inventory process');

        try {
            $validatedData = $this->validate();
            Excel::import(new InventoryTransactionImport, $validatedData['import']);
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
            return view('livewire.dashboard.inventory-transactions.datatable', [
                'inventoryTransactions' => InventoryTransaction::with(['supplier'])->restaurant()->onlyTrashed()->latest()->paginate()
            ]);
        }
        return view('livewire.dashboard.inventory-transactions.datatable', [
            'inventoryTransactions' => InventoryTransaction::with(['supplier'])->restaurant()->latest()->paginate()
        ]);
    }
}
