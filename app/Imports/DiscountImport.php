<?php

namespace App\Imports;

use App\Models\Discount;
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

class DiscountImport implements
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
     * @return Discount|null
     */
    public function model(array $row)
    {
        return new Discount([
            'restaurant_id' => auth()->user()->restaurant_id,
            'name_ar'     => $row['name_ar'],
            'name_en'     => $row['name_en'],
            'type'     => $row['type'],
            'value'     => $row['value'],
            'applies_to'     => $row['applies_to'],
            'activate_for'     => $row['activate_for'],
            'is_taxable'     => $row['is_taxable'],
            'start_date'     => $row['start_date'],
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
            '*.name_ar' => 'required|min:3|max:25',
            '*.name_en' => 'required|min:3|max:25',
            '*.type' => 'required',
            '*.value' => 'required|numeric',
            '*.applies_to' => "required",
            '*.activate_for' => 'required',
            '*.is_taxable' => 'boolean',
            '*.start_date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
        ];
    }
}
