<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;

class InventoryTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Edit Inventory process')->only('edit');
        $this->middleware('permission:Create Inventory process')->only('create');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.inventory-transactions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.inventory-transactions.create');
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
     * @param  \App\Models\InventoryTransaction  $inventoryTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(InventoryTransaction $inventoryTransaction)
    {
        /*
        return view('dashboard.inventory-transactions.show', [
            'inventoryTransaction' => $inventoryTransaction
        ]);*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventoryTransaction  $inventoryTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(InventoryTransaction $inventoryTransaction)
    {
        return view('dashboard.inventory-transactions.edit', [
            'inventoryTransaction' => $inventoryTransaction
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventoryTransaction  $inventoryTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InventoryTransaction $inventoryTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventoryTransaction  $inventoryTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(InventoryTransaction $inventoryTransaction)
    {
        //
    }
}
