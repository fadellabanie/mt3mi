<?php

namespace App\Exports\Reports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SalarySheet implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
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
            'Salary',
        ];
    }

    public function collection()
    {
        return $this->export;
    }

    public function map($item): array
    {
        return [
            $item->name,
            $item->business_role,
            $item->salary,
        ];
    }
}
