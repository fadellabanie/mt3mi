<?php

namespace App\Imports;

use App\Models\InventoryItem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class InventoryItemImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    SkipsOnFailure,
    WithBatchInserts,
    WithChunkReading
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return InventoryItem|null
     */
    public function model(array $row)
    {
        return new InventoryItem([
            'restaurant_id' => auth()->user()->restaurant_id,
            'name_ar'     => $row['name_ar'],
            'name_en'     => $row['name_en'],
            'type'     => $row['type'],
            'sku'     => $row['sku'],
            'barcode'     => $row['barcode'],
            'quantity'     => $row['quantity'],
            'purchase_unit'     => $row['purchase_unit'],
            'storage_unit'     => $row['storage_unit'],
            'ingredient_unit'     => $row['ingredient_unit'],
            'purchase_to_storage_factor'     => $row['purchase_to_storage_factor'],
            'storage_to_ingredient_factor'     => $row['storage_to_ingredient_factor'],
            'cost_type'     => $row['cost_type'],
            'cost'     => $row['cost'],
            'minimum_level_alert'     => $row['minimum_level_alert'],
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
            '*.name_ar' => 'required|string|min:3|max:25',
            '*.name_en' => 'required|string|min:3|max:25',
            '*.type' => 'required',
            '*.sku' => 'nullable|string',
            '*.barcode' => 'nullable|string',
            '*.purchase_unit' => 'required|string',
            '*.storage_unit' => 'required|string',
            '*.ingredient_unit' => 'required|string',
            '*.purchase_to_storage_factor' => 'required|numeric',
            '*.storage_to_ingredient_factor' => 'required|numeric',
            '*.cost_type' => 'required',
            '*.cost' => 'nullable|numeric|required_if:cost_type,fixed',
            '*.minimum_level_alert' => 'required|numeric',
            '*.itemTags' => 'nullable',
        ];
    }
}
