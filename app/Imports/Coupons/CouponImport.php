<?php

namespace App\Imports\Coupons;

use App\Imports\Coupons\FirstSheetImport;
use App\Imports\Coupons\ThirdSheetImport;
use App\Imports\Coupons\SecondSheetImport;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CouponImport implements

    WithHeadingRow,
    SkipsOnError,
    SkipsOnFailure,
    WithMultipleSheets
{
    use Importable, SkipsErrors, SkipsFailures;


    public function sheets(): array
    {
        return [
            'coupons' => new FirstSheetImport(),
            'created_by' => new SecondSheetImport(),
            'days' => new ThirdSheetImport(),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        info("Sheet {$sheetName} was skipped");
    }
}
