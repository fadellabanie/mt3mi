<?php

namespace App\Exports\Reports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PurchasePerSupplier implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $export;

    public function __construct($export)
    {
        $this->export = $export;
    }

    public function headings(): array
    {
        return [
            'Supplier Name',
            'Item Name',
            'Purchase Quantity',
            'Storage Quantity',
            'Ingredient Quantity',
            'Price',
        ];
    }

    public function collection()
    {
        return $this->export;
    }

    public function map($item): array
    {
        return [
            $item->supplier->name,
            $item->inventoryItem->name,
            $item->purchase_quantity,
            $item->storage_quantity,
            $item->ingredient_quantity,
            (string) $item->cost,
        ];
    }
}
