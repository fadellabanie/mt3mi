<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use phpDocumentor\Reflection\Types\Boolean;

class ProductExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function headings(): array
    {
        return [
            'Arabic Name',
            'English Name',
            'Description Name',
            'Description Name',
            'Category',
            'pricing Type',
            'Selling Type',
            'Sku',
            'Barcode',
            'Preparation Time',
            'Is Taxable',
            'Is Active',
            'Created At',
            /*
            'Size Arabic Name',
            'Size English Name',
            'Size Barcode',
            'Size Sku',
            'Size Calories',
            'Size Cost Type',
            'Size Cost',
            'Size Price',
            'Size Is Active'*/
        ];
    }

    public function collection()
    {
        return Product::with(['category'])->restaurant()
        ->isCombo(false)   
        ->select(
                'name_ar',
                'name_en',
                'description_ar',
                'description_en',
                'category_id',
                'pricing_type',
                'selling_type',
                'sku',
                'barcode',
                'preparation_time',
                'is_taxable',
                'is_active',
                'created_at'
            )->get();
    }


    public function map($product): array
    {
       
        return [
            $product->name_ar,
            $product->name_en,
            $product->description_ar,
            $product->description_en,
            $product->category->name,
            $product->pricing_type,
            $product->selling_type,
            $product->sku,
            $product->barcode,
            $product->preparation_time,
            (bool) $product->is_taxable,
            (bool) $product->is_active,
            $product->created_at->toDateTimeString(),
            /*
            $product->productSizes->name_ar,
            $product->productSizes->name_en,
            $product->productSizes->barcode,
            $product->productSizes->sku,
            $product->productSizes->calories,
            $product->productSizes->cost_type,
            $product->productSizes->cost,
            $product->productSizes->price,
            (bool) $product->productSizes->is_active,
            */
        ];
    }
}
