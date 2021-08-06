<?php

namespace App\Http\Livewire\Dashboard\TimedEvents;

use Livewire\Component;
use App\Models\TimedEvent;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\TimedEventExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TimedEvents\TimedEventImport;
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
        $this->authorize('Delete Temporary activities');

        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        TimedEvent::restaurant()->findOrFail($this->selectedId)->delete();
    }
    public function restore($id)
    {
        $row = TimedEvent::restaurant()->whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = TimedEvent::restaurant()->whereId($id)->withTrashed()->first();
        $row->forceDelete();
    }
    public function export()
    {
        $this->authorize('Export Temporary activities');

        return Excel::download(new TimedEventExport, 'timed-events.xlsx');
    }
    public function import()
    {
        $this->authorize('Import Temporary activities');

        try {
            $validatedData = $this->validate();
            Excel::import(new TimedEventImport, $validatedData['import']);
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
            return view('livewire.dashboard.timed-events.datatable', [
                'timedEvents' => TimedEvent::restaurant()->onlyTrashed()->paginate()
            ]);
        }
        return view('livewire.dashboard.timed-events.datatable', [
            'timedEvents' => TimedEvent::restaurant()->latest()->paginate()
        ]);
    }
}
