<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class SupplierExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function headings(): array
    {
        return [
            'Name',
            'Code',
            'Contact Name',
            'Email',
            'Phone',
            'Created At',
        ];
    }

    public function collection()
    {
        return Supplier::restaurant()
            ->select(
                'name',
                'code',
                'contact_name',
                'email',
                'phone',
                'created_at'
            )->get();
    }


    public function map($supplier): array
    {
        return [
            $supplier->name,
            $supplier->code,
            $supplier->contact_name,
            $supplier->email,
            $supplier->phone,
            $supplier->created_at->toDateTimeString(),
        ];
    }
}
