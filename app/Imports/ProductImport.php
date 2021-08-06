<?php

namespace App\Imports;

use App\Models\Product;
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

class ProductImport implements
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
     * @return Product|null
     */
    public function model(array $row)
    {
        return new Product([
            'restaurant_id' => auth()->user()->restaurant_id,
            'name_ar'     => $row['name_ar'],
            'name_en'     => $row['name_en'],
            'description_ar'     => $row['description_ar'],
            'description_en'     => $row['description_en'],
            'category_id'     => $row['category_id'],
            'pricing_type'     => $row['pricing_type'],
            'selling_type'     => $row['selling_type'],
            'sku'     => $row['sku'],
            'barcode'     => $row['barcode'],
            'preparation_time'     => $row['preparation_time'],
            'is_taxable'     => $row['is_taxable'],
            'is_active'     => $row['is_active'],
            'is_combo'     => $row['is_combo'],
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
            '*.description_ar' => 'nullable|string|max:500',
            '*.description_en' => 'nullable|string|max:500',
            '*.category_id' => 'required|exists:categories,id',
            '*.pricing_type' => 'required',
            '*.selling_type' => 'required',
            '*.sku' => 'nullable|string|min:3|max:25',
            '*.barcode' => 'nullable|string|min:3|max:25',
            '*.preparation_time' => 'nullable|numeric',

        ];
    }
}
