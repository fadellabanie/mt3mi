<?php

namespace App\Imports\Coupons;

use App\Models\CouponDay;
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
     * @return CouponDay|null
     */
    public function model(array $row)
    {
        return new CouponDay([
            'coupon_id'     => $row['coupon_id'],
            'day'     => $row['day'],
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
            '*.coupon_id' => 'required',
            '*.day' => 'required',
        ];
    }
}
