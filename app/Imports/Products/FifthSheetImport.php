<?php

namespace App\Imports\Products;

use App\Models\ProductSize;
use App\Models\ProductModifier;
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

class FifthSheetImport implements
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
     * @return ProductModifier|null
     */
    public function model(array $row)
    {
        return new ProductModifier([
            'restaurant_id' => auth()->user()->restaurant_id,
            'product_id'     => $row['product_id'],
            'modifier_id'     => $row['modifier_id'],
            'minimum_options'     => $row['minimum_options'],
            'maximum_options'     => $row['maximum_options'],
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
            '*.minimum_options' => 'required|numeric',
            '*.maximum_options' => 'required|numeric'

        ];
    }
}
