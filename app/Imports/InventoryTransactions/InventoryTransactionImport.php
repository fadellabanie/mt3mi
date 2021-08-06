<?php

namespace App\Imports\InventoryTransactions;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\InventoryTransactions\FirstSheetImport;
use App\Imports\InventoryTransactions\ThirdSheetImport;
use App\Imports\InventoryTransactions\SecondSheetImport;


class InventoryTransactionImport implements

    WithHeadingRow,
    SkipsOnError,
    SkipsOnFailure,
    WithMultipleSheets
{
    use Importable, SkipsErrors, SkipsFailures;


    public function sheets(): array
    {
        return [
            'suppliers' => new FirstSheetImport(),
            'inventory-transactions' => new SecondSheetImport(),
            'inventory-items' => new ThirdSheetImport(),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        info("Sheet {$sheetName} was skipped");
    }
}
