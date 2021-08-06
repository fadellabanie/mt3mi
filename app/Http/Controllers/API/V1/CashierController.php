<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Restaurant as RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'account_number' => 'required'
        ]);

        $restaurant = Restaurant::where('account_number', $request->account_number)->firstOrFail();

        return new RestaurantResource($restaurant->load(['users']));
    }
}
