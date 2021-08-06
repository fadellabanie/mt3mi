<?php

namespace App\Exports;

use App\Models\Coupon;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CouponExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function headings(): array
    {
        return [
            'Name',
            'Code',
            'Type',
            'Value',
            'Valid From',
            'Valid To',
            'From Time',
            'To Time',
            'Created By',
            'Is Active',
            'Is Used',
            'Created At',
        ];
    }

    public function collection()
    {
        return Coupon::with('creator')->restaurant()
            ->select(
                'name',
                'code',
                'type',
                'value',
                'valid_from',
                'valid_to',
                'from_time',
                'to_time',
                'created_by',
                'is_active',
                'is_used',
                'created_at'
            )->get();
    }


    public function map($coupon): array
    {
        return [
            $coupon->name,
            $coupon->code,
            $coupon->type,
            $coupon->value,
            $coupon->valid_from,
            $coupon->valid_from,
            $coupon->from_time,
            $coupon->to_time,
            $coupon->creator->name ?? "",
            (Boolean) $coupon->is_active,
            (Boolean) $coupon->is_used,
            $coupon->created_at->toDateTimeString(),
        ];
    }
}
