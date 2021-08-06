<?php

namespace App\Http\Livewire\Dashboard\LoyalPoints;

use Livewire\Component;
use App\Models\LoyalPoint;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\LoyalPointExport;
use App\Imports\LoyalPointImport;
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
        $this->authorize('Delete Loyalty point');

        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        LoyalPoint::restaurant()->findOrFail($this->selectedId)->delete();
    }
    public function restore($id)
    {
        $row = LoyalPoint::restaurant()->whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = LoyalPoint::restaurant()->whereId($id)->withTrashed()->first();
        $row->forceDelete();
    }
    public function export()
    {
        $this->authorize('Export Loyalty point');

        return Excel::download(new LoyalPointExport, 'loyal-points.xlsx');
    }
    public function import()
    {
        $this->authorize('Import Loyalty point');

        try {
            $validatedData = $this->validate();
            Excel::import(new LoyalPointImport, $validatedData['import']);
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
            return view('livewire.dashboard.loyal-points.datatable', [
                'loyalPoints' => LoyalPoint::restaurant()->onlyTrashed()->paginate()
            ]);
        }
        return view('livewire.dashboard.loyal-points.datatable', [
            'loyalPoints' => LoyalPoint::restaurant()->latest()->paginate()
        ]);
    }
}
