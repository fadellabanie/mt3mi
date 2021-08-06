<?php

namespace App\Imports\Products;

use App\Models\ProductSize;
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

class ThirdSheetImport implements
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
     * @return ProductSize|null
     */
    public function model(array $row)
    {
        return new ProductSize([
            'restaurant_id' => auth()->user()->restaurant_id,
            'product_id'     => $row['product_id'],
            'name_ar'     => $row['name_ar'],
            'name_en'     => $row['name_en'],
            'barcode'     => $row['barcode'],
            'sku'     => $row['sku'],
            'calories'     => $row['calories'],
            'cost_type'     => $row['cost_type'],
            'cost'     => $row['cost'],
            'price'     => $row['price'],
            'is_active'     => $row['is_active'],
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
            '*.barcode' => 'nullable|string|min:3|max:25',
            '*.sku' => 'nullable|min:3|max:25',
            '*.calories' => 'nullable|numeric',
            '*.cost_type' => 'required',
            '*.cost' => 'nullable|numeric|required_if:cost_type,fixed',
            '*.price' => 'nullable|numeric'

        ];
    }
}
