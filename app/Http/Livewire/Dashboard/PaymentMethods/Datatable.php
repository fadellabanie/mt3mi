<?php

namespace App\Http\Livewire\Dashboard\PaymentMethods;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PaymentMethod;
use Livewire\WithFileUploads;
use App\Exports\PaymentMethodExport;
use App\Imports\PaymentMethodImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Datatable extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';

    public $import;
    public $selectedId;
    public $onlyTrashed = false;

    protected $rules = [
        'import' => 'required',
    ];

    public function confirm($id)
    {
        $this->authorize('Delete Payment method');

        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        PaymentMethod::restaurant()->findOrFail($this->selectedId)->delete();
    }
    public function restore($id)
    {
        $row = PaymentMethod::whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = PaymentMethod::whereId($id)->withTrashed()->first();
        $row->forceDelete();
    }
    public function export()
    {
        $this->authorize('Export Payment method');

        return Excel::download(new PaymentMethodExport, 'payment-methods.xlsx');
    }

    public function import()
    {
        $this->authorize('Import Payment method');

        try {
            $validatedData = $this->validate();
            Excel::import(new PaymentMethodImport, $validatedData['import']);
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
            return view('livewire.dashboard.payment-methods.datatable', [
                'paymentMethods' => PaymentMethod::restaurant()->onlyTrashed()->paginate()
            ]);
        }
       

        $paymentMethods = PaymentMethod::restaurant()->paginate();

        $paymentMethods->whenEmpty(function ($paymentMethods) {
            return $paymentMethods->push(PaymentMethod::create([
                'restaurant_id' => auth()->user()->restaurant_id,
                'name' => 'Cash',
                'type' => 'Cash',
                'auto_open_cash_drawer' => 1,
                'is_active' => 1
            ]));
        });

        return view('livewire.dashboard.payment-methods.datatable', [
            'paymentMethods' => $paymentMethods
        ]);
    }
}
