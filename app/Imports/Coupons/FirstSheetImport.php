<?php

namespace App\Imports\Coupons;

use App\Models\Coupon;
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

class FirstSheetImport implements
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
     * @return Coupon|null
     */
    public function model(array $row)
    {
        return new Coupon([
            'restaurant_id' => auth()->user()->restaurant_id,
            'name'     => $row['name'],
            'code'     => $row['code'],
            'type'     => $row['type'],
            'value'     => $row['value'],
            'valid_from'     => $row['valid_from'],
            'valid_to'     => $row['valid_to'],
            'from_time'     => $row['from_time'],
            'to_time'     => $row['to_time'],
            'created_by'     => $row['created_by'],
            'is_active' => $row['is_active'],
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
            '*.name' => 'required|min:3|max:25',
            '*.type' => 'required',
            '*.value' => 'required|numeric',
            '*.valid_from' => "required|date|date_format:Y-m-d|after_or_equal:today",
            '*.valid_to' => 'required|date|date_format:Y-m-d|after_or_equal:valid_from',
            '*.from_time' => 'nullable',
            '*.to_time' => 'nullable',
            '*.created_by' => 'nullable',
            '*.is_active' => 'nullable',
        ];
    }
}
