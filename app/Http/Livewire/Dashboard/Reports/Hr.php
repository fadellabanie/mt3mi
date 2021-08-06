<?php

namespace App\Http\Livewire\Dashboard\Reports;

use App\Exports\Reports\AttendanceSheet;
use App\Exports\Reports\SalarySheet;
use App\Models\User;
use Livewire\Component;
use App\Models\Attendance;
use Maatwebsite\Excel\Facades\Excel;

class Hr extends Component
{
    public $user = 'all';

    public function exportSalarySheet()
    {
        $data = User::restaurant()->get();

        return Excel::download(new SalarySheet($data), 'salaries.xlsx');
    }

    public function exportAttendanceSheet()
    {
        $data = Attendance::restaurant()->when($this->user != 'all', function ($query) {
            return $query->where('user_id', '=', $this->user);
        })->with(['user'])->get();

        return Excel::download(new AttendanceSheet($data), 'attendance.xlsx');
    }

    public function render()
    {
        return view('livewire.dashboard.reports.hr', [
            'users' => User::restaurant()->get()
        ])->layout('layouts.admin');
    }
}
