<?php

namespace App\Http\Livewire\Dashboard\Restores;

use App\Models\Tag;
use App\Models\Coupon;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Modifier;
use App\Models\Supplier;
use App\Models\WorkShift;
use App\Models\LoyalPoint;
use App\Models\TimedEvent;
use App\Models\DelayPolicy;
use App\Models\InventoryItem;
use App\Models\PaymentMethod;
use App\Models\InventoryTransaction;
use App\Models\ProductSize;

class Datatable extends Component
{
    public $categories;
    public $products;
    public $combos;
    public $coupons;
    public $delayPolicies;
    public $discounts;
    public $inventoryItems;
    public $inventoryTransactions;
    public $loyalPoints;
    public $modifiers;
    public $sizes;
    public $paymentMethods;
    public $InventoryTransactions;
    public $tags;
    public $suppliers;
    public $timedEvents;
    public $workShifts;


    public function mount()
    {
        $this->categories = Category::restaurant()->onlyTrashed()->count();
        $this->combos = Product::isCombo(true)->restaurant()->onlyTrashed()->count();
        $this->products = Product::isCombo(false)->restaurant()->onlyTrashed()->count();
        $this->coupons = Coupon::restaurant()->onlyTrashed()->count();
        $this->delayPolicies = DelayPolicy::restaurant()->onlyTrashed()->count();
        $this->discounts = Discount::restaurant()->onlyTrashed()->count();
        $this->inventoryItems = InventoryItem::restaurant()->onlyTrashed()->count();
        $this->inventoryTransactions = InventoryTransaction::restaurant()->onlyTrashed()->count();
        $this->loyalPoints = LoyalPoint::restaurant()->onlyTrashed()->count();
        $this->modifiers = Modifier::restaurant()->onlyTrashed()->count();
        $this->sizes = ProductSize::restaurant()->onlyTrashed()->count();
        $this->paymentMethods = PaymentMethod::restaurant()->onlyTrashed()->count();
        $this->timedEvents = TimedEvent::restaurant()->onlyTrashed()->count();
        $this->tags = Tag::restaurant()->onlyTrashed()->count();
        $this->workShifts = WorkShift::restaurant()->onlyTrashed()->count();
        $this->suppliers = Supplier::restaurant()->onlyTrashed()->count();
    }
    public function render()
    {
        return view('livewire.dashboard.restores.datatable');
    }
}
