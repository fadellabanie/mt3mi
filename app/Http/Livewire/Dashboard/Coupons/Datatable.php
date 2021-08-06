<?php

namespace App\Http\Livewire\Dashboard\Coupons;

use App\Models\Coupon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\CouponExport;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Coupons\CouponImport;
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
        $this->authorize('Delete Coupons');
        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        Coupon::findOrFail($this->selectedId)->delete();
    }
    public function restore($id)
    {
        $row = Coupon::whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = Coupon::whereId($id)->withTrashed()->first();
        $row->forceDelete();
    }
    public function export()
    {
        $this->authorize('Export Coupons');

        return Excel::download(new CouponExport, 'coupons.xlsx');
    }
    public function import()
    {
        $this->authorize('Import Coupons');

        try {
            $validatedData = $this->validate();
            Excel::import(new CouponImport, $validatedData['import']);
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
            return view('livewire.dashboard.coupons.datatable', [
                'coupons' => Coupon::restaurant()->onlyTrashed()->paginate()
            ]);
        }

        return view('livewire.dashboard.coupons.datatable', [
            'coupons' => Coupon::restaurant()->latest()->paginate()
        ]);
    }
}
