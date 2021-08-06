<?php

namespace App\Exports;

use App\Models\PaymentMethod;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PaymentMethodExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function headings(): array
    {
        return [
            'Name',
            'Code',
            'Type',
            'Auto Open Cash Drawer',
            'Is Active',
            'Created At',
        ];
    }

    public function collection()
    {
        return PaymentMethod::restaurant()
            ->select(
                'name',
                'code',
                'type',
                'auto_open_cash_drawer',
                'is_active',
                'created_at'
            )->get();
    }


    public function map($paymentMethod): array
    {
        return [
            $paymentMethod->name,
            $paymentMethod->type,
            $paymentMethod->code,
            $paymentMethod->auto_open_cash_drawer,
           (boolean) $paymentMethod->is_active ,
            $paymentMethod->created_at->toDateTimeString(),
        ];
    }
}
