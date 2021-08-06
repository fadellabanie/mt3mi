<?php

namespace App\Imports\WorkShifts;


use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use App\Imports\WorkShifts\FirstSheetImport;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use App\Imports\WorkShifts\SecondSheetImport;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WorkShiftImport implements

    WithHeadingRow,
    SkipsOnError,
    SkipsOnFailure,
    WithMultipleSheets
{
    use Importable, SkipsErrors, SkipsFailures;

    public function sheets(): array
    {
        return [
            'work-shifts' => new FirstSheetImport(),
            'days' => new SecondSheetImport(),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        info("Sheet {$sheetName} was skipped");
    }
}
