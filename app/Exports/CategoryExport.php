<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\WithMapping;
use phpDocumentor\Reflection\Types\Boolean;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CategoryExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function headings(): array
    {
        return [
            'Arabic Name',
            'English Name',
            'Parent',
            'Sku',
            'Is Active',
            'Created At',
        ];
    }

    public function collection()
    {
        return Category::with(['father'])->restaurant()
            ->select(
                'name_ar',
                'name_en',
                'sku',
                'parent_id',
                'is_active',
                'created_at'
            )->get();
    }


    public function map($category): array
    {
        return [
            $category->name_ar,
            $category->name_en,
            $category->father != null ? $category->father->name : "Is Parent",
            $category->sku,
            (boolean) $category->is_active,
            $category->created_at->toDateTimeString(),
        ];
    }
}
