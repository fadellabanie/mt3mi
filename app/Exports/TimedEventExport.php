<?php

namespace App\Exports;

use App\Models\TimedEvent;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TimedEventExport implements FromCollection, WithHeadings, ShouldAutoSize, Withmapping
{
    public function headings(): array
    {
        return [
            'Arabic Name',
            'English Name',
            'Type',
            'Value',
            'Is Active',
            'From Date',
            'To Date',
            'From Hour',
            'To Hour',
            'Created At',
        ];
    }

    public function collection()
    {
        return TimedEvent::restaurant()
            ->select(
                'name_ar',
                'name_en',
                'type',
                'value',
                'is_active',
                'from_date',
                'to_date',
                'from_hour',
                'to_hour',
                'created_at'
            )->get();
    }


    public function map($timedEvent): array
    {
        return [
            $timedEvent->name_ar,
            $timedEvent->name_en,
            $timedEvent->type,
            $timedEvent->value,
            $timedEvent->is_active,
            $timedEvent->from_date,
            $timedEvent->to_date,
            $timedEvent->from_hour,
            $timedEvent->to_hour,
            $timedEvent->created_at->toDateTimeString(),
        ];
    }
}
