<?php

namespace App\Http\Livewire\Dashboard\Discounts;

use Livewire\Component;
use App\Models\Discount;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\DiscountExport;
use App\Imports\DiscountImport;
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
        $this->authorize('Delete Discounts');

        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        Discount::restaurant()->findOrFail($this->selectedId)->delete();
    }
    public function restore($id)
    {
        $row = Discount::whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = Discount::whereId($id)->withTrashed()->first();
        $row->forceDelete();
    }
    public function export()
    {
        $this->authorize('Export Discounts');

        return Excel::download(new DiscountExport, 'discount.xlsx');
    }
    public function import()
    {
        $this->authorize('Import Discounts');

        try {
            $validatedData = $this->validate();
            Excel::import(new DiscountImport, $validatedData['import']);
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
            return view('livewire.dashboard.discounts.datatable', [
                'discounts' => Discount::restaurant()->onlyTrashed()->paginate()
            ]);
        }

        return view('livewire.dashboard.discounts.datatable', [
            'discounts' => Discount::restaurant()->latest()->paginate()
        ]);
    }
}
