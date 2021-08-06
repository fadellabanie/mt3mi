<?php

namespace App\Exports;

use App\Models\Modifier;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ModifierExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function headings(): array
    {
        return [
            'Arabic Name',
            'English Name',
            'Sku',
            'Barcode',
            'Is Multiple',
            'Is Active',
            'Created At',
        ];
    }

    public function collection()
    {
        return Modifier::restaurant()
            ->select(
                'name_ar',
                'name_en',
                'sku',
                'barcode',
                'is_multiple',
                'is_active',
                'created_at'
            )->get();
    }


    public function map($modifier): array
    {
        return [
            $modifier->name_ar,
            $modifier->name_en,
            $modifier->sku,
            $modifier->barcode,
            (bool) $modifier->is_multiple,
            (bool) $modifier->is_active,
            $modifier->created_at->toDateTimeString(),
        ];
    }
}
