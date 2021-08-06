<?php

namespace App\Imports\InventoryTransactions;

use Illuminate\Support\Collection;
use App\Models\InventoryTransaction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SecondSheetImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    WithBatchInserts,
    WithChunkReading
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return InventoryTransaction|null
     */
    public function model(array $row)
    {

        return new InventoryTransaction([
            'restaurant_id' => auth()->user()->restaurant_id,
            'business_date'     => $row['business_date'],
            'supplier_id'     => $row['supplier_id'],
            'invoice_number'     => $row['invoice_number'],
            'invoice_date'     => $row['invoice_date'],
            'paid_tax'     => $row['paid_tax'],
            'notes'     => $row['notes'],
            'inventory_item_id'     => $row['inventory_item_id'],
            'purchase_quantity'     => $row['purchase_quantity'],
            'storage_quantity'     => $row['storage_quantity'],
            'ingredient_quantity'     => $row['ingredient_quantity'],
            'cost'     => $row['cost'],
            'expiration_date'     => $row['expiration_date'],
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return config('excel.exports.chunk_size');
    }

    public function rules(): array
    {
        return [
            '*.supplier_id' => 'required|exists:suppliers,id',
            '*.invoice_number' => 'nullable|string',
            '*.invoice_date' => 'nullable|date',
            '*.paid_tax' => 'numeric|min:0',
            '*.notes' => 'nullable|string',
            '*.inventory_item_id' => 'required|exists:inventory_items,id',
            '*.purchase_quantity' => 'numeric|min:0',
            '*.storage_quantity' => 'numeric|min:0',
            '*.ingredient_quantity' => 'numeric|min:0',
            '*.cost' => 'numeric|min:0',
            '*.expiration_date' => 'nullable|date',
        ];
    }
}
