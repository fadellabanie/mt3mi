<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;

class HomeController extends Controller
{

   public function __invoke()
   {
        $data['inventory_transactions'] = InventoryTransaction::Restaurant()->count();
        $data['suppliers'] = Supplier::Restaurant()->count();
        $data['inventory_items'] = InventoryItem::Restaurant()->count();

        $data['employees'] = User::Restaurant()->count();
        $data['products'] = Product::Restaurant()->count();
        $data['categories'] = Category::Restaurant()->count();

        $data['orders'] = Order::Restaurant()->Done()->orderBy('id','DESC')->take(10);

        return view('dashboard', [
           'data' => $data
        ]);
   }
}