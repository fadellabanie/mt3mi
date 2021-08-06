<?php

namespace App\Exports;

use App\Models\Discount;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DiscountExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function headings(): array
    {
        return [
            'Arabic Name',
            'English Name',
            'Type',
            'Value',
            'Applies To',
            'Activate For',
            'Is Taxable',
            'Start Date',
            'Created At',
        ];
    }

    public function collection()
    {
        return Discount::restaurant()
            ->select(
                'name_ar',
                'name_en',
                'type',
                'value',
                'applies_to',
                'activate_for',
                'is_taxable',
                'start_date',
                'created_at'
            )->get();
    }


    public function map($discount): array
    {
        return [
            $discount->name_ar,
            $discount->name_en,
            $discount->type,
            $discount->value,
            $discount->applies_to,
            $discount->activate_for,
           (boolean) $discount->is_taxable ?? false,
            $discount->start_date,
            $discount->created_at->toDateTimeString(),
        ];
    }
}
