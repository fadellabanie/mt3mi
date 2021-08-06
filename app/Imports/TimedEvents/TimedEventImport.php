<?php

namespace App\Imports\TimedEvents;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use App\Imports\TimedEvents\FirstSheetImport;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use App\Imports\TimedEvents\SecondSheetImport;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TimedEventImport implements

    WithHeadingRow,
    SkipsOnError,
    SkipsOnFailure,
    WithMultipleSheets
{
    use Importable, SkipsErrors, SkipsFailures;


    public function sheets(): array
    {
        return [
            'timed-events' => new FirstSheetImport(),
            'days' => new SecondSheetImport(),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        info("Sheet {$sheetName} was skipped");
    }
}
