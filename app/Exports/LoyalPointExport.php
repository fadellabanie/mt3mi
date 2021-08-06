<?php

namespace App\Exports;

use App\Models\LoyalPoint;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LoyalPointExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function headings(): array
    {
        return [
            'Arabic Name',
            'English Name',
            'Points',
            'Discount',
            'Created At',
        ];
    }

    public function collection()
    {
        return LoyalPoint::restaurant()
            ->select(
                'name_ar',
                'name_en',
                'points',
                'discount',
                'created_at'
            )->get();
    }


    public function map($loyalPoint): array
    {
        return [
            $loyalPoint->name_ar,
            $loyalPoint->name_en,
            $loyalPoint->points,
            $loyalPoint->discount,
            $loyalPoint->created_at->toDateTimeString(),
        ];
    }
}
