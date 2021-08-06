<?php

namespace App\Exports\Reports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ItemBySKU implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $export;

    public function __construct($export)
    {
        $this->export = $export;
    }

    public function headings(): array
    {
        return [
            'Item Name',
            'SKU',
            'Purchase Quantity',
            'Storage Quantity',
            'Ingredient Quantity',
        ];
    }

    public function collection()
    {
        return $this->export;
    }

    public function map($item): array
    {
        return [
            $item->inventoryItem->name,
            $item->inventoryItem->sku,
            $item->purchase_quantity,
            $item->storage_quantity,
            $item->ingredient_quantity,
        ];
    }
}
