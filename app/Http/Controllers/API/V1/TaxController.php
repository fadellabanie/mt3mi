<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaxResource;
use App\Models\FinancialSetting;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TaxResource::collection(
            FinancialSetting::restaurant()
            ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FinancialSetting  $financialSetting
     * @return \Illuminate\Http\Response
     */
    public function show(FinancialSetting $financialSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FinancialSetting  $financialSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinancialSetting $financialSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FinancialSetting  $financialSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinancialSetting $financialSetting)
    {
        //
    }
}
