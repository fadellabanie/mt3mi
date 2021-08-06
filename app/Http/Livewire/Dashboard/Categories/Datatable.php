<?php

namespace App\Http\Livewire\Dashboard\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\CategoryExport;
use App\Imports\CategoryImport;
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
        $this->authorize('Delete Category');
        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        Category::restaurant()->findOrFail($this->selectedId)->delete();
    }

    public function restore($id)
    {
        $row = Category::restaurant()->whereId($id)->withTrashed()->first();
        $row->restore();
    }

    public function delete($id)
    {
        $row = Category::with('products')->restaurant()->whereId($id)->withTrashed()->first();

        if (!$row->products()->exists()) {
            $row->forceDelete();
        }

        session()->flash('alert', __('Cannot Delete This Row.'));
    }

    public function export()
    {
        $this->authorize('Export Category');

        return Excel::download(new CategoryExport, 'categories.xlsx');
    }

    public function import()
    {
        $this->authorize('Import Category');

        try {
            $validatedData = $this->validate();
            Excel::import(new CategoryImport, $validatedData['import']);
            session()->flash('alert', __('Saved Successfully.'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $th) {
            foreach ($th->errors() as $key => $error) {
                session()->flash('alert', $error);
            }
        }
    }

    public function render()
    {
        return view('livewire.dashboard.categories.datatable', [
            'categories' => ($this->onlyTrashed) ?
                Category::restaurant()->withCount(['products'])->onlyTrashed()->paginate() :
                Category::restaurant()->withCount(['products'])->paginate()
        ]);
    }
}
