<?php

namespace App\Http\Livewire\Dashboard\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
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
        $this->authorize('Delete Products');

        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        Product::isCombo(false)->restaurant()->findOrFail($this->selectedId)->delete();
    }
    public function restore($id)
    {
        $row = Product::isCombo(false)->restaurant()->whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = Product::isCombo(false)->restaurant()->whereId($id)->withTrashed()->first();
        $row->forceDelete();
    }
    public function export()
    {
        $this->authorize('Export Products');

        return Excel::download(new ProductExport, 'products.xlsx');
    }
    public function import()
    {
        $this->authorize('Import Products');

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
            return view('livewire.dashboard.products.datatable', [
                'products' => Product::isCombo(false)->with(['category'])
                    ->withCount(['productSizes', 'productModifiers'])
                    ->restaurant()
                    ->onlyTrashed()
                    ->paginate()
            ]);
        }
        return view('livewire.dashboard.products.datatable', [
            'products' => Product::isCombo(false)->with(['category'])
                ->withCount(['productSizes', 'productModifiers'])
                ->restaurant()
                ->paginate()
        ]);
    }
}
