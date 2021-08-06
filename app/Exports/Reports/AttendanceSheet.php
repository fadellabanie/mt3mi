<?php

namespace App\Exports\Reports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AttendanceSheet implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $export;

    public function __construct($export)
    {
        $this->export = $export;
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Job Title',
            'Check In',
            'Check Out',
            'Date',
        ];
    }

    public function collection()
    {
        return $this->export;
    }

    public function map($item): array
    {
        return [
            $item->user->name,
            $item->user->business_role,
            $item->check_in,
            $item->check_out,
            $item->created_at->toDateTimeString()
        ];
    }
}
