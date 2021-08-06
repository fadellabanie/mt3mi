<?php

namespace App\Imports\WorkShifts;

use Auth;

use App\Models\WorkShift;
use Illuminate\Support\Facades\Hash;
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
     * @return WorkShift|null
     */
    public function model(array $row)
    {
        return new WorkShift([
            'restaurant_id' => auth()->user()->restaurant_id,
            'name_ar'     => $row['name_ar'],
            'name_en'     => $row['name_en'],
            'from_time' => $row['from_time'],
            'to_time'    => $row['to_time'],
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
            '*.from_time' => 'required',
            '*.to_time' => 'required',
        ];
    }
}
