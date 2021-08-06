<?php

namespace App\Exports;

use App\Models\DelayPolicy;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class DelayPolicyExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function headings(): array
    {
        return [
            'Arabic Name',
            'English Name',
            'Calculate After',
            'Discount From Salary',
            'Created At',
        ];
    }

    public function collection()
    {
        return DelayPolicy::restaurant()
            ->select(
                'name_ar',
                'name_en',
                'calculate_after',
                'discount_from_salary',
                'created_at'
            )->get();
    }


    public function map($delayPolicy): array
    {
        return [
            $delayPolicy->name_ar,
            $delayPolicy->name_en,
            $delayPolicy->calculate_after,
            $delayPolicy->discount_from_salary,
            $delayPolicy->created_at->toDateTimeString(),
        ];
    }
}
