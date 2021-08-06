<?php

namespace App\Imports\Products;

use App\Imports\Products\FifthSheetImport;
use App\Imports\Products\FirstSheetImport;
use App\Imports\Products\FourthSheetImport;
use App\Imports\Products\SecondSheetImport;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class ComboImport implements

    WithHeadingRow,
    SkipsOnError,
    SkipsOnFailure,
    WithMultipleSheets
{
    use Importable, SkipsErrors, SkipsFailures;


    public function sheets(): array
    {
        return [
            'combos' => new FirstSheetImport(),
            'categories' => new SecondSheetImport(),
            'sizes' => new ThirdSheetImport(),
            'modifiers' => new FourthSheetImport(),
            'product-modifiers' => new FifthSheetImport(),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        info("Sheet {$sheetName} was skipped");
    }
}
