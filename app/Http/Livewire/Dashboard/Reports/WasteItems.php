<?php

namespace App\Http\Livewire\Dashboard\Reports;

use Livewire\Component;
use App\Models\ProductSize;
use App\Models\WasteProduct;
use App\Models\InventoryItem;
use App\Exports\Reports\WasteItems as WasteItemsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Reports\WasteProducts;

class WasteItems extends Component
{
    public $product = 'all';
    public $item = 'all';

    public function exportByWasteProduct()
    {
        $data = WasteProduct::restaurant()->when($this->product != 'all', function ($query) {
            return $query->where('model_id', '=', $this->product);
        })->where('model_type', ProductSize::class)
            ->with(['productSize'])
            ->get();

        return Excel::download(new WasteProducts($data), 'waste_products.xlsx');
    }

    public function exportByWasteItem()
    {
        $data = WasteProduct::restaurant()->when($this->item != 'all', function ($query) {
            return $query->where('model_id', '=', $this->item);
        })->where('model_type', InventoryItem::class)
            ->with(['inventoryItem'])
            ->get();

        return Excel::download(new WasteItemsExport($data), 'waste_items.xlsx');
    }

    public function render()
    {
        return view('livewire.dashboard.reports.waste-items', [
            'productSizes' => ProductSize::restaurant()->get(),
            'inventoryItems' => InventoryItem::restaurant()->get(),
        ])->layout('layouts.admin');
    }
}
