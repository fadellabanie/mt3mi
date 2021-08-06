<?php

namespace App\Http\Livewire\Dashboard\Reports;

use App\Exports\Reports\TillLogs as ReportsTillLogs;
use App\Models\Till;
use Livewire\Component;
use App\Models\TillOperation;
use Maatwebsite\Excel\Facades\Excel;

class TillLogs extends Component
{
    public $till = 'all';

    public function exportByTill()
    {
        $data = TillOperation::whereHas('till', function ($query) {
            $query->restaurant();
        })->when($this->till != 'all', function ($query) {
            $query->whereHas('till', function ($query) {
                $query->where('id', $this->till);
            });
        })->get();

        return Excel::download(new ReportsTillLogs($data), 'till_logs.xlsx');
    }

    public function render()
    {
        return view('livewire.dashboard.reports.till-logs', [
            'tills' => Till::restaurant()->get()
        ])->layout('layouts.admin');
    }
}
