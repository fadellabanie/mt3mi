<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\LoyalPoint;
use Illuminate\Http\Request;

class LoyalPointController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Create Loyalty point')->only('create');
        $this->middleware('permission:Edit Loyalty point')->only('edit');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.loyal-points.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.loyal-points.create');
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
     * @param  \App\Models\LoyalPoint  $loyalPoint
     * @return \Illuminate\Http\Response
     */
    public function show(LoyalPoint $loyalPoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoyalPoint  $loyalPoint
     * @return \Illuminate\Http\Response
     */
    public function edit(LoyalPoint $loyalPoint)
    {
        return view('dashboard.loyal-points.edit', [
            'loyalPoint' => $loyalPoint
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoyalPoint  $loyalPoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoyalPoint $loyalPoint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoyalPoint  $loyalPoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoyalPoint $loyalPoint)
    {
        //
    }
}
