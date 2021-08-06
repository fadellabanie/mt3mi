<?php

namespace App\Exports;

use App\Models\InventoryItem;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventoryItemExport  implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithMapping
{
    public function headings(): array
    {
        return [
            'Arabic Name',
            'English Name',
            'Type',
            'Sku',
            'Barcode',
            'Quantity',
            'Purchase Unit',
            'Storage Unit',
            'Ingredient Unit',
            'Purchase To Storage Factor',
            'Storage To Ingredient Factor',
            'Cost Type',
            'Cost',
            'Minimum Level Alert',
            'Created At',
        ];
    }

    public function collection()
    {
        return InventoryItem::restaurant()
            ->select(
                'name_ar',
                'name_en',
                'type',
                'sku',
                'barcode',
                'quantity',
                'purchase_unit',
                'storage_unit',
                'ingredient_unit',
                'purchase_to_storage_factor',
                'storage_to_ingredient_factor',
                'cost_type',
                'cost',
                'minimum_level_alert',
                'created_at'
            )->get();
    }


    public function map($inventoryItem): array
    {
        return [
            $inventoryItem->name_ar,
            $inventoryItem->name_en,
            $inventoryItem->type,
            $inventoryItem->sku,
            $inventoryItem->barcode,
            $inventoryItem->quantity,
            $inventoryItem->purchase_unit,
            $inventoryItem->storage_unit,
            $inventoryItem->ingredient_unit,
            $inventoryItem->purchase_to_storage_factor,
            $inventoryItem->storage_to_ingredient_factor,
            $inventoryItem->cost_type,
            $inventoryItem->cost,
            $inventoryItem->minimum_level_alert,
            $inventoryItem->created_at->toDateTimeString(),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
            'M' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
            'N' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
