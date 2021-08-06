<?php

namespace App\Exports;

use App\Models\InventoryTransaction;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class InventoryTransactionExport implements FromCollection,WithMapping, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'Business Date',
            'Supplier',
            'Invoice Number',
            'Invoice Date',
            'Paid Tax',
            'Notes',
            'Inventory Item',
            'Purchase Quantity',
            'Storage Quantity',
            'Ingredient Quantity',
            'Cost',
            'Expiration Date',
            'Status',
            'Created At',
        ];
    }

    public function collection()
    {
        return InventoryTransaction::with('supplier','inventoryItem')->restaurant()
            ->select(
                'business_date',
                'supplier_id',
                'invoice_number',
                'invoice_date',
                'paid_tax',
                'notes',
                'inventory_item_id',
                'purchase_quantity',
                'storage_quantity',
                'ingredient_quantity',
                'cost',
                'expiration_date',
                'status',
                'created_at'
            )->get();
    }


    public function map($inventoryTransaction): array
    {
        return [
            $inventoryTransaction->business_date,
            $inventoryTransaction->supplier->name ??"",
            $inventoryTransaction->invoice_number,
            $inventoryTransaction->invoice_date,
            $inventoryTransaction->paid_tax,
            $inventoryTransaction->notes,
            $inventoryTransaction->inventoryItem->name_ar,
            $inventoryTransaction->purchase_quantity,
            $inventoryTransaction->storage_quantity,
            $inventoryTransaction->ingredient_quantity,
            $inventoryTransaction->cost,
            $inventoryTransaction->expiration_date,
            $inventoryTransaction->status,
            $inventoryTransaction->created_at,
        ];
    }
}
