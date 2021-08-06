<?php

namespace App\Http\Controllers\API\V1;

use App\Models\OrderType;
use App\Models\WorkShift;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderType as OrderTypeResource;
use App\Http\Resources\WorkShift as WorkShiftResource;
use App\Http\Resources\PaymentMethod as PaymentMethodResource;

class BaseController extends Controller
{
    public function general()
    {
        $paymentMethods =  PaymentMethod::restaurant()->get();

        $paymentMethods->whenEmpty(function ($paymentMethods) {
            return $paymentMethods->push(PaymentMethod::create([
                'restaurant_id' => auth()->user()->restaurant_id,
                'name' => 'Cash',
                'type' => 'Cash',
                'auto_open_cash_drawer' => 1,
                'is_active' => 1
            ]));
        });

        $data['payment_methods'] = PaymentMethodResource::collection($paymentMethods);

        $data['order_types'] = OrderTypeResource::collection(OrderType::all());

        $data['work_shifts'] = WorkShiftResource::collection(WorkShift::restaurant()->get());

        return response()->json(['data' => $data]);
    }
}
