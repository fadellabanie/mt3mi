<?php

namespace App\Imports;

use App\Models\Category;
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

class CategoryImport implements
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
     * @return Category|null
     */
    public function model(array $row)
    {
        return new Category([
            'restaurant_id' => auth()->user()->restaurant_id,
            'name_ar'     => $row['name_ar'],
            'name_en'     => $row['name_en'],
            'parent_id' => $row['parent_id'] ?? "",
            'sku'     => $row['sku'],
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
            '*.sku' => 'required|string|min:3|max:25',
        ];
    }
}
