<?php

namespace App\Imports\TimedEvents;

use App\Models\Coupon;
use App\Models\TimedEvent;
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
     * @return TimedEvent|null
     */
    public function model(array $row)
    {
        return new TimedEvent([
            'restaurant_id' => auth()->user()->restaurant_id,
            'name_ar'     => $row['name_ar'],
            'name_en'     => $row['name_en'],
            'type'     => $row['type'],
            'from_date' => $row['from_date'],
            'to_date' => $row['to_date'],
            'from_hour' => $row['from_hour'],
            'to_hour' => $row['to_hour'],
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
            '*.name_ar' => 'required|min:3|max:25',
            '*.name_en' => 'required|min:3|max:25',
            '*.type' => 'required',
            '*.is_active' => 'boolean',
            '*.from_date' => "required|date|date_format:Y-m-d|after_or_equal:today",
            '*.to_date' => 'required|date|date_format:Y-m-d|after_or_equal:from_date',
            '*.from_hour' => 'required',
            '*.to_hour' => 'required',
        ];
    }
}
