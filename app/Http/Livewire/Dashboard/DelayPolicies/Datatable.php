<?php

namespace App\Http\Livewire\Dashboard\DelayPolicies;

use Livewire\Component;
use App\Models\DelayPolicy;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\DelayPolicyExport;
use App\Imports\DelayPolicyImport;
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
        $this->authorize('Delete Delay policies');
        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        DelayPolicy::restaurant()->findOrFail($this->selectedId)->delete();
    }
    public function restore($id)
    {
        $row = DelayPolicy::whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = DelayPolicy::whereId($id)->withTrashed()->first();
        $row->forceDelete();
    }
    public function export()
    {
        $this->authorize('Export Delay policies');

        return Excel::download(new DelayPolicyExport, 'delay-Policies.xlsx');
    }
    public function import()
    {
        $this->authorize('Import Delay policies');

        try {
            $validatedData = $this->validate();
            Excel::import(new DelayPolicyImport, $validatedData['import']);
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
            return view('livewire.dashboard.delay-policies.datatable', [
                'delayPolicies' => DelayPolicy::restaurant()->onlyTrashed()->paginate()
            ]);
        }
        return view('livewire.dashboard.delay-policies.datatable', [
            'delayPolicies' => DelayPolicy::restaurant()->paginate()
        ]);
    }
}
