<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DelayPolicy;
use Illuminate\Http\Request;

class DelayPolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Create Delay policies')->only('create');
        $this->middleware('permission:Edit Delay policies')->only('edit');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.delay-policies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.delay-policies.create');
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
     * @param  \App\Models\DelayPolicy  $delayPolicy
     * @return \Illuminate\Http\Response
     */
    public function show(DelayPolicy $delayPolicy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DelayPolicy  $delayPolicy
     * @return \Illuminate\Http\Response
     */
    public function edit(DelayPolicy $delayPolicy)
    {
        return view('dashboard.delay-policies.edit', [
            'delayPolicy' => $delayPolicy
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DelayPolicy  $delayPolicy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DelayPolicy $delayPolicy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DelayPolicy  $delayPolicy
     * @return \Illuminate\Http\Response
     */
    public function destroy(DelayPolicy $delayPolicy)
    {
        //
    }
}
