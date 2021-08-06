<?php

namespace App\Http\Livewire\Dashboard\WorkShifts;

use Livewire\Component;
use App\Models\WorkShift;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\WorkShiftExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WorkShifts\WorkShiftImport;
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
        $this->authorize('Delete Work Shift');

        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        WorkShift::restaurant()->findOrFail($this->selectedId)->delete();
    }
    public function restore($id)
    {
        $row = WorkShift::whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = WorkShift::whereId($id)->withTrashed()->first();
        $row->forceDelete();
    }
    public function export()
    {
        $this->authorize('Export Work Shift');

        return Excel::download(new WorkShiftExport, 'work-shifts.xlsx');
    }
    public function import()
    {
        $this->authorize('Import Work Shift');

        try {
            $validatedData = $this->validate();
            Excel::import(new WorkShiftImport, $validatedData['import']);
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
            return view('livewire.dashboard.work-shifts.datatable', [
                'workShifts' => WorkShift::restaurant()->onlyTrashed()->paginate()
            ]);
        }
        return view('livewire.dashboard.work-shifts.datatable', [
            'workShifts' => WorkShift::restaurant()->paginate()
        ]);

    }
}
