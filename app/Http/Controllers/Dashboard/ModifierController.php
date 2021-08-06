<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Modifier;
use Illuminate\Http\Request;

class ModifierController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Create Add ons')->only('create');
        $this->middleware('permission:Edit Add ons')->only('edit');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.modifiers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.modifiers.create');
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
     * @param  \App\Models\Modifier  $modifier
     * @return \Illuminate\Http\Response
     */
    public function show(Modifier $modifier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modifier  $modifier
     * @return \Illuminate\Http\Response
     */
    public function edit(Modifier $modifier)
    {
        return view('dashboard.modifiers.edit', [
            'modifier' => $modifier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modifier  $modifier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modifier $modifier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modifier  $modifier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modifier $modifier)
    {
        //
    }
}
