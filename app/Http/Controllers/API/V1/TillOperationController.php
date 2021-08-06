<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Till;
use Illuminate\Http\Request;
use App\Models\TillOperation;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\API\StoreTillOperationRequest;
use App\Http\Resources\TillOperation as TillOperationResource;

class TillOperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Till  $till
     * @return \Illuminate\Http\Response
     */
    public function index(Till $till)
    {
        return TillOperationResource::collection(
            $till->operations
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Till  $till
     * @param  \App\Http\Requests\API\StoreTillOperationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTillOperationRequest $request, Till $till)
    {
        if ($till->closed_at != '') {
            throw ValidationException::withMessages([
                'message' => __("You can't add more operations till is closed."),
            ]);
        }

        $request->createOperation($till);

        return response()->json([
            'message' => __('Saved Successfully.')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TillOperation  $tillOperation
     * @return \Illuminate\Http\Response
     */
    public function show(TillOperation $tillOperation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TillOperation  $tillOperation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TillOperation $tillOperation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TillOperation  $tillOperation
     * @return \Illuminate\Http\Response
     */
    public function destroy(TillOperation $tillOperation)
    {
        //
    }
}
