<?php

namespace App\Imports\InventoryTransactions;

use App\Models\Supplier;
use Illuminate\Support\Collection;
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
     * @return Supplier|null
     */
    public function model(array $row)
    {
        return new Supplier([
            'restaurant_id' => auth()->user()->restaurant_id,
            'name'     => $row['name'],
            'code'     => $row['code'],
            'contact_name' => $row['contact_name'],
            'phone'    => $row['phone'],
            'email'    => $row['email'],
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
            '*.contact_name' => 'nullable|string|min:3|max:25',
            '*.email' => 'nullable|string|email|max:255',
            '*.phone' => ['nullable', 'regex:/^(5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
        ];
    }
}
