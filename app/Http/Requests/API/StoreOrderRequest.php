<?php

namespace App\Http\Requests\API;

use App\Models\Order;
use App\Models\ProductSize;
use App\Models\OrderProduct;
use App\Models\ModifierOption;
use Illuminate\Support\Facades\DB;
use App\Models\OrderProductModifier;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    protected $subTotal = 0;
    protected $discount = 0;
    protected $total = 0;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'order_type_id' => 'required|exists:order_types,id',
            'work_shift_id' => 'nullable|exists:work_shifts,id',
            'persons' => 'required|integer',
            'notes' => 'nullable|string',
            'call_name' => 'nullable|string|required_if:order_type_id,1',
            'coupon_id' => 'nullable|exists:coupons,id',
            'due_time' => 'nullable|date|date_format:Y-m-d H:i',
            'join_order' => 'nullable|exists:orders,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'products' => 'array',
            'products.*.id' => 'required|exists:product_sizes,id',
            'products.*.quantity' => 'required|integer',
            'modifiers' => 'array',
            'modifiers.*.size_id' => 'nullable|exists:product_sizes,id|required_with:modifiers.*.id,modifiers.*.quantity',
            'modifiers.*.id' => 'nullable|exists:modifier_options,id|required_with:modifiers.*.size_id,modifiers.*.quantity',
            'modifiers.*.quantity' => 'nullable|integer|required_with:modifiers.*.id,modifiers.*.size_id',
        ];
    }

    public function createOrder()
    {
        DB::transaction(function () {
            $order = Order::create([
                'restaurant_id' => auth()->user()->restaurant_id,
                'cashier_id' => auth()->id(),
                'order_type_id' => $this->order_type_id,
                'work_shift_id' => $this->work_shift_id,
                'persons' => $this->persons,
                'notes' => $this->notes,
                'call_name' => $this->call_name,
                'coupon_id' => $this->coupon_id,
                'due_time' => $this->due_time,
                'join_order' => $this->join_order,
                'status' => 'new',
                'payment_method_id' => $this->payment_method_id,
            ]);

            $this->addOrderProducts($order);

            $order->update([
                'subtotal' => $this->subTotal,
                'discount' => $this->discount,
                'total' => $this->total,
            ]);
        });
    }

    public function addOrderProducts(Order $order)
    {
        foreach ($this->products as $product) {
            $price = ProductSize::where('id', $product['id'])->value('price');

            $orderProduct = OrderProduct::create([
                'order_id' => $order->id,
                'product_size_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $price,
                'discount' => 0,
                'total' => $price * $product['quantity'],
            ]);

            $this->calculateOrder($price, $product['quantity']);

            $modifiers = collect($this->modifiers)->where('size_id', $product['id'])->all();

            if (collect($modifiers)->isNotEmpty()) {
                $this->addOrderProductModifiers($orderProduct, collect($modifiers));
            }
        }
    }

    public function addOrderProductModifiers(OrderProduct $orderProduct, $modifiers)
    {
        foreach ($modifiers as $modifier) {
            $price = ModifierOption::where('id', $modifier['id'])->value('price');

            OrderProductModifier::create([
                'order_product_id' => $orderProduct->id,
                'modifier_option_id' => $modifier['id'],
                'quantity' => $modifier['quantity'],
                'price' => $price,
                'discount' => 0,
                'total' => $price * $modifier['quantity'],
            ]);
        }

        $this->calculateOrder($price, $modifier['quantity']);
    }

    public function calculateOrder($price, $quantity)
    {
        $this->subTotal += $price * $quantity;
        $this->discount += 0;
        $this->total += $this->subTotal - $this->discount;
    }
}
