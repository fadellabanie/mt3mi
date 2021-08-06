<?php

use App\Http\Controllers\API\V1\AppSettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\TillController;
use App\Http\Controllers\API\V1\FloorController;
use App\Http\Controllers\API\V1\LoginController;
use App\Http\Controllers\API\V1\CashierController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\AttendanceController;
use App\Http\Controllers\API\V1\BaseController;
use App\Http\Controllers\API\V1\CouponController;
use App\Http\Controllers\API\V1\DiscountController;
use App\Http\Controllers\API\V1\InventoryItemController;
use App\Http\Controllers\API\V1\OrderController;
use App\Http\Controllers\API\V1\TaxController;
use App\Http\Controllers\API\V1\TillOperationController;
use App\Http\Controllers\API\V1\WasteProductController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('cashier', CashierController::class);
    Route::post('login', [LoginController::class, 'login']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::apiResource('categories', CategoryController::class)->only('index');
        Route::apiResource('attendances', AttendanceController::class);
        Route::apiResource('floors', FloorController::class);
        Route::apiResource('tills', TillController::class);
        Route::apiResource('tills.till-operations', TillOperationController::class)->shallow();
        Route::get('general', [BaseController::class, 'general']);
        Route::apiResource('orders', OrderController::class);
        Route::apiResource('waste-products', WasteProductController::class);
        Route::apiResource('app-settings', AppSettingController::class);
        Route::get('inventory-items', InventoryItemController::class);
        Route::apiResource('coupons', CouponController::class);
        Route::apiResource('discounts', DiscountController::class);
        Route::apiResource('taxes', TaxController::class);
    });
});
