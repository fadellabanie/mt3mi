<?php

namespace App\Imports;

use App\Models\PaymentMethod;
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

class PaymentMethodImport implements
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
     * @return PaymentMethod|null
     */
    public function model(array $row)
    {
        return new PaymentMethod([
            'restaurant_id' => auth()->user()->restaurant_id,
            'name'     => $row['name'],
            'type'     => $row['type'],
            'code' => $row['code'],
            'auto_open_cash_drawer'    => $row['auto_open_cash_drawer'],
            'is_active'    => $row['is_active'],
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
            '*.name' => 'required|string|min:3|max:25',
            '*.code' => 'nullable|string|min:3|max:25',
            '*.type' => 'required',
            '*.auto_open_cash_drawer' => 'boolean',
            '*.is_active' => 'boolean'
        ];
    }
}
