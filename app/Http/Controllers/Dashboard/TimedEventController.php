<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TimedEvent;
use Illuminate\Http\Request;

class TimedEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Edit Temporary activities')->only('edit');
        $this->middleware('permission:Create Temporary activities')->only('create');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.timed-events.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.timed-events.create');
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
     * @param  \App\Models\TimedEvent  $timedEvent
     * @return \Illuminate\Http\Response
     */
    public function show(TimedEvent $timedEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimedEvent  $timedEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(TimedEvent $timedEvent)
    {
        return view('dashboard.timed-events.edit', [
            'timedEvent' => $timedEvent->load(['timedEventDays', 'timedEventOrderTypes'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimedEvent  $timedEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimedEvent $timedEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimedEvent  $timedEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimedEvent $timedEvent)
    {
        //
    }
}
