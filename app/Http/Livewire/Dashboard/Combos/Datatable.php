<?php

namespace App\Http\Livewire\Dashboard\Combos;

use App\Models\Product;
use Livewire\Component;
use App\Exports\ComboExport;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Products\ComboImport;
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
        $this->authorize('Delete Combo');
        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        Product::isCombo(true)->findOrFail($this->selectedId)->delete();
    }
    public function restore($id)
    {
        $row = Product::isCombo(true)->whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = Product::isCombo(true)->whereId($id)->withTrashed()->first();
        $row->forceDelete();
    }
    public function export()
    {
        $this->authorize('Export Combo');

        return Excel::download(new ComboExport, 'combos.xlsx');
    }
    public function import()
    {
        $this->authorize('Import Combo');

        try {
            $validatedData = $this->validate();
            Excel::import(new ComboImport, $validatedData['import']);
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
            return view('livewire.dashboard.combos.datatable', [
                'products' => Product::isCombo(true)->with(['category'])
                    ->withCount(['productSizes', 'productModifiers'])
                    ->restaurant()
                    ->onlyTrashed()
                    ->paginate()
            ]);
        }
        return view('livewire.dashboard.combos.datatable', [
            'products' => Product::isCombo(true)->with(['category'])
                ->withCount(['productSizes', 'productModifiers'])
                ->restaurant()
                ->paginate()
        ]);
    }
}
