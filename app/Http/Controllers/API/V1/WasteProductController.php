<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreWasteProductRequest;
use App\Models\WasteProduct;
use Illuminate\Http\Request;

class WasteProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWasteProductRequest $request)
    {
        WasteProduct::create([
            'model_id' => $request->id,
            'model_type' =>  WasteProduct::$modelClasses[$request->type],
            'user_id' => auth()->id(),
            'quantity' => $request->quantity,
            'note' => $request->note
        ]);

        return response()->json([
            'message' => __('Saved Successfully.')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WasteProduct  $wasteProduct
     * @return \Illuminate\Http\Response
     */
    public function show(WasteProduct $wasteProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WasteProduct  $wasteProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WasteProduct $wasteProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WasteProduct  $wasteProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(WasteProduct $wasteProduct)
    {
        //
    }
}
