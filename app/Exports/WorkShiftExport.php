<?php

namespace App\Exports;

use App\Models\WorkShift;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WorkShiftExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function headings(): array
    {
        return [
            'Arabic Name',
            'English Name',
            'From Time',
            'To Time',
            'Created At',
        ];
    }

    public function collection()
    {
        return WorkShift::restaurant()
            ->select(
                'name_ar',
                'name_en',
                'from_time',
                'to_time',
                'created_at'
            )->get();
    }


    public function map($workShift): array
    {
        return [
            $workShift->name_ar,
            $workShift->name_en,
            $workShift->from_time,
            $workShift->to_time,
            $workShift->created_at->toDateTimeString(),
        ];
    }
}
