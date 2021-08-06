<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use App\Http\Livewire\Dashboard\Reports\Hr;
use App\Http\Livewire\Dashboard\Reports\Items;
use App\Http\Livewire\Dashboard\Reports\Sales;
use App\Http\Controllers\Dashboard\TagController;
use App\Http\Livewire\Dashboard\Reports\TillLogs;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ComboController;
use App\Http\Livewire\Dashboard\Reports\WasteItems;
use App\Http\Controllers\Dashboard\CouponController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DiscountController;
use App\Http\Controllers\Dashboard\ModifierController;
use App\Http\Controllers\Dashboard\RestoresController;
use App\Http\Controllers\Dashboard\SupplierController;
use App\Http\Controllers\Dashboard\WorkShiftController;
use App\Http\Controllers\Dashboard\AppSettingController;
use App\Http\Controllers\Dashboard\LoyalPointController;
use App\Http\Controllers\Dashboard\TimedEventController;
use App\Http\Controllers\Dashboard\DelayPolicyController;
use App\Http\Controllers\Dashboard\MenuDisplayController;
use App\Http\Controllers\Dashboard\ProductItemController;
use App\Http\Controllers\Dashboard\BusinessInfoController;
use App\Http\Controllers\Dashboard\ModifierItemController;
use App\Http\Controllers\Dashboard\InventoryItemController;
use App\Http\Controllers\Dashboard\PaymentMethodController;
use App\Http\Controllers\Dashboard\ChangePasswordController;
use App\Http\Controllers\Dashboard\MenuActivationController;
use App\Http\Controllers\Dashboard\InventoryTransactionController;

Route::get('/dashboard', HomeController::class)->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth']], function () {
    Route::group(['middleware' => ['vendor']], function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('tags', TagController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('users', UserController::class);
        Route::resource('coupons', CouponController::class);
        Route::resource('payment-methods', PaymentMethodController::class);
        Route::resource('timed-events', TimedEventController::class);
        Route::resource('loyal-points', LoyalPointController::class);
        Route::resource('work-shifts', WorkShiftController::class);
        Route::resource('delay-policies', DelayPolicyController::class);
        Route::resource('discounts', DiscountController::class);
        Route::resource('inventory-items', InventoryItemController::class);
        Route::resource('modifiers', ModifierController::class);
        Route::get('modifiers/{modifier}/items', ModifierItemController::class)->name('modifiers.items.index');
        Route::resource('products', ProductController::class);
        Route::get('products/{product}/items', ProductItemController::class)->name('products.items.index');
        Route::get('products/{product}/components', App\Http\Livewire\Dashboard\ProductComponents::class)->name('products.components.index');
        Route::get('menu-activation/products', [MenuActivationController::class, 'products'])->name('menu-activation.products')->middleware('permission:Activate menu');
        Route::get('menu-activation/categories', [MenuActivationController::class, 'categories'])->name('menu-activation.categories')->middleware('permission:Activate menu');
        Route::get('menu-activation/sizes', [MenuActivationController::class, 'sizes'])->name('menu-activation.sizes')->middleware('permission:Activate menu');
        Route::get('menu-activation/tags', [MenuActivationController::class, 'tags'])->name('menu-activation.tags')->middleware('permission:Activate menu');
        Route::get('menu-activation/modifiers', [MenuActivationController::class, 'modifiers'])->name('menu-activation.modifiers')->middleware('permission:Activate menu');
        Route::resource('inventory-transactions', InventoryTransactionController::class);
        Route::resource('combos', ComboController::class);
        Route::get('menu-display/categories', [MenuDisplayController::class, 'categories'])->name('menu-display.categories')->middleware('permission:Show menu');
        Route::get('menu-display/tags', [MenuDisplayController::class, 'tags'])->name('menu-display.tags')->middleware('permission:Show menu');
        Route::get('restores', RestoresController::class)->name('settings.restores.index')->middleware('permission:Restore Data');
        Route::get('settings/business-info', BusinessInfoController::class)->name('settings.business-info');
        Route::get('settings/app-settings', AppSettingController::class)->name('settings.app-settings');
        Route::get('financial-settings', \App\Http\Livewire\Dashboard\FinancialSettings\Datatable::class)->name('financial-settings.index');
        Route::get('financial-settings/create', \App\Http\Livewire\Dashboard\FinancialSettings\Create::class)->name('financial-settings.create');
        Route::get('financial-settings/{financialSetting}', \App\Http\Livewire\Dashboard\FinancialSettings\Update::class)->name('financial-settings.edit');

        Route::get('profile', ProfileController::class)->name('profile.index');
        Route::get('change-password', ChangePasswordController::class)->name('change-password');
        Route::get('reports/items', Items::class)->name('reports.items')->middleware('permission:Show Reports');
        Route::get('reports/sales', Sales::class)->name('reports.sales')->middleware('permission:Show Reports');
        Route::get('reports/waste-items', WasteItems::class)->name('reports.waste-items')->middleware('permission:Show Reports');
        Route::get('reports/till-logs', TillLogs::class)->name('reports.till-logs')->middleware('permission:Show Reports');
        Route::get('reports/hr', Hr::class)->name('reports.hr')->middleware('permission:Show Reports');
       
        Route::resource('qr-code', QrCodeController::class);

        Route::get('test',function(){
            $user = Auth::user();
            $permission = Permission::create(['name' => 'Edit Inventory process']);

            $user->givePermissionTo($permission);
            return back();
        });
    });
});
