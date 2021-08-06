<?php

namespace App\Http\Livewire\Dashboard\InventoryItems;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InventoryItem;
use Livewire\WithFileUploads;
use App\Exports\InventoryItemExport;
use App\Imports\InventoryItemImport;
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
        $this->authorize('Delete Item inventory');

        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        InventoryItem::findOrFail($this->selectedId)->delete();
    }
    public function restore($id)
    {
        $row = InventoryItem::whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = InventoryItem::whereId($id)->withTrashed()->first();
        $row->forceDelete();
    }
    public function export()
    {
        $this->authorize('Export Item inventory');

        return Excel::download(new InventoryItemExport, 'inventory-items.xlsx');
    }
    public function import()
    {
        $this->authorize('Import Item inventory');

        try {
            $validatedData = $this->validate();
            Excel::import(new InventoryItemImport, $validatedData['import']);
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
            return view('livewire.dashboard.inventory-items.datatable', [
                'inventoryItems' => InventoryItem::with('tags')->restaurant()->onlyTrashed()->paginate()
            ]);
        }
        return view('livewire.dashboard.inventory-items.datatable', [
            'inventoryItems' => InventoryItem::with('tags')->restaurant()->paginate()
        ]);
    }
}
