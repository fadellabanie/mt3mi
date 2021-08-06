<?php

namespace App\Exports\Reports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SalesByCategory implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $export;

    public function __construct($export)
    {
        $this->export = $export;
    }

    public function headings(): array
    {
        return [
            'Category',
            'Total',
        ];
    }

    public function collection()
    {
        return $this->export;
    }

    public function map($item): array
    {
        return [
            $item->orderProducts->productSize->product->category->name,
            $item->orderProducts->total,
        ];
    }
}
