<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreOrderRequest;
use App\Http\Requests\API\UpdateOrderRequest;
use App\Http\Resources\Order as OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OrderResource::collection(
            Order::restaurant()
                ->with(['cashier', 'orderType', 'paymentMethod'])
                ->when(request()->filled('status'), function ($query) {
                    $query->status(request()->get('status'));
                })
                ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $request->createOrder();

        return response()->json([
            'message' => __('Saved Successfully.')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrderResource(
            $order->load(['cashier', 'orderType', 'paymentMethod', 'orderProducts.productSize.product', 'orderProducts.orderProductModifiers.modifierOption.modifier'])
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $request->createOrder();

        return response()->json([
            'message' => __('Saved Successfully.')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
