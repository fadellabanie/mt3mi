<?php

namespace App\Http\Controllers\API\V1;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppSetting as AppSettingResource;

class AppSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AppSettingResource (AppSetting::firstOrCreate([
            'restaurant_id' => auth()->user()->restaurant_id,
            'order_type_id' => 1
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_type_id' => 'nullable|exists:order_types,id',
            'logout_inactive_after' => 'nullable|integer',
            'reset_order_number_after' => 'nullable|integer',
            'void_require_customer_info' => 'boolean',
            'discount_require_customer_info' => 'boolean',
            'run_in_submode' => 'boolean',
            'receipt_language' => 'required|string',
            'receipt_header' => 'nullable|string',
            'receipt_footer' => 'nullable|string',
            'waiter_app_background' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'cashier_app_background' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'customer_app_background' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'receipt_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($request->hasFile('waiter_app_background')) {
            $validatedData['waiter_app_background'] = $this->waiter_app_background->store('app_settings', 'public');
        }

        if ($request->hasFile('cashier_app_background')) {
            $validatedData['cashier_app_background'] = $this->cashier_app_background->store('app_settings', 'public');
        }

        if ($request->hasFile('customer_app_background')) {
            $validatedData['customer_app_background'] = $this->customer_app_background->store('app_settings', 'public');
        }

        if ($request->hasFile('receipt_logo')) {
            $validatedData['receipt_logo'] = $this->receipt_logo->store('app_settings', 'public');
        }

        AppSetting::where('restaurant_id', auth()->user()->restaurant_id)->update($validatedData);

        return response()->json([
            'message' => __('Saved Successfully.')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AppSetting  $appSetting
     * @return \Illuminate\Http\Response
     */
    public function show(AppSetting $appSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AppSetting  $appSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AppSetting $appSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AppSetting  $appSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppSetting $appSetting)
    {
        //
    }
}
