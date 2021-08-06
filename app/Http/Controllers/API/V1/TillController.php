<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Till;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Till as TillResource;
use Illuminate\Validation\ValidationException;

class TillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TillResource::collection(
            Till::restaurant()
                ->cashier()
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
        $till = Till::where('user_id', auth()->id())
            ->whereNull('closed_at')
            ->first();

        if ($till) {
            throw ValidationException::withMessages([
                'message' => __('You must close open till first.'),
            ]);
        }

        Till::create([
            'restaurant_id' => auth()->user()->restaurant_id,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => __('Saved Successfully.')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Till  $till
     * @return \Illuminate\Http\Response
     */
    public function show(Till $till)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Till  $till
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Till $till)
    {
        $till->close();

        return response()->json([
            'message' => __('Saved Successfully.')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Till  $till
     * @return \Illuminate\Http\Response
     */
    public function destroy(Till $till)
    {
        //
    }
}
