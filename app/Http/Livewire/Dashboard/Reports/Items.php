<?php

namespace App\Http\Livewire\Dashboard\Reports;

use App\Exports\Reports\ItemByCost;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\InventoryItem;
use App\Exports\Reports\ItemBySKU;
use App\Exports\Reports\ItemByType;
use App\Models\InventoryTransaction;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Reports\PurchasePerSupplier;
use App\Exports\Reports\ItemByExpirationDate;
use App\Exports\Reports\ItemByTypeAndCost;

class Items extends Component
{
    public $supplier = 'all';
    public $sku = 'all';
    public $type = 'all';
    public $expiration_date = null;
    public $cost = null;

    public function exportPurchasePerSupplier()
    {
        $data = InventoryTransaction::restaurant()->when($this->supplier != 'all', function ($query) {
            $query->where('supplier_id', $this->supplier);
        })->with(['supplier', 'inventoryItem'])->get();

        return Excel::download(new PurchasePerSupplier($data), 'purchase_per_supplier.xlsx');
    }

    public function exportByItemSKU()
    {
        $data = InventoryTransaction::restaurant()->when($this->sku != 'all', function ($query) {
            $query->whereHas('inventoryItem', function ($query) {
                $query->where('sku', '=', $this->sku);
            });
        })->with(['inventoryItem'])->get();

        return Excel::download(new ItemBySKU($data), 'item_by_sku.xlsx');
    }

    public function exportByItemType()
    {
        $data = InventoryTransaction::restaurant()->when($this->type != 'all', function ($query) {
            return $query->whereHas('inventoryItem', function ($query) {
                $query->where('type', '=', $this->type);
            });
        })->with(['inventoryItem'])->get();

        return Excel::download(new ItemByType($data), 'item_by_type.xlsx');
    }

    public function exportByExpirationDate()
    {
        $data = InventoryTransaction::restaurant()->when(! is_null($this->expiration_date) , function ($query) {
            return $query->whereDate('expiration_date', '=', Carbon::parse($this->expiration_date));
        })->with(['inventoryItem'])->get();

        return Excel::download(new ItemByExpirationDate($data), 'item_by_expiration_date.xlsx');
    }

    public function exportByItemCost()
    {
        $data = InventoryTransaction::restaurant()->when(! is_null($this->cost) , function ($query) {
            return $query->where('cost', '=', $this->cost);
        })->with(['inventoryItem'])->get();

        return Excel::download(new ItemByCost($data), 'item_by_cost.xlsx');
    }

    public function exportByItemTypeAndCost()
    {
        $data = InventoryTransaction::restaurant()->when($this->type != 'all', function ($query) {
            return $query->whereHas('inventoryItem', function ($query) {
                $query->where('type', '=', $this->type);
            });
        })->when(!is_null($this->cost), function ($query) {
            return $query->where('cost', '=', $this->cost);
        })->with(['inventoryItem'])->get();

        return Excel::download(new ItemByTypeAndCost($data), 'item_by_type_and_cost.xlsx');
    }

    public function render()
    {
        return view('livewire.dashboard.reports.items', [
            'suppliers' => Supplier::restaurant()->get(),
            'itemSkues' => InventoryItem::restaurant()->groupBy('sku')->pluck('sku')
        ])->layout('layouts.admin');
    }
}
