<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WorkShift;
use Illuminate\Http\Request;

class WorkShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Edit Work Shift')->only('edit');
        $this->middleware('permission:Create Work Shift')->only('create');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.work-shifts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.work-shifts.create');
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
     * @param  \App\Models\WorkShift  $workShift
     * @return \Illuminate\Http\Response
     */
    public function show(WorkShift $workShift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkShift  $workShift
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkShift $workShift)
    {
        return view('dashboard.work-shifts.edit', [
            'workShift' => $workShift
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkShift  $workShift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkShift $workShift)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkShift  $workShift
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkShift $workShift)
    {
        //
    }
}
