<?php

namespace App\Http\Resources;

use App\Http\Resources\OrderProduct as OrderProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'cashier' => [
                'id' => $this->cashier->id,
                'name' => $this->cashier->name
            ],
            'order_type' => [
                'id' => $this->orderType->id,
                'name' => $this->orderType->name
            ],
            'persons' => (int) $this->persons,
            'notes' => (string) $this->notes,
            'call_name' => (string) $this->call_name,
            //'coupon' => (string) $this->coupon->code,
            'due_time' => (string) $this->due_time,
            'join_order' => ($this->join_order) ? $this->join_order : '',
            'status' => $this->status,
            'payment_method' => [
                'id' => $this->paymentMethod->id,
                'name' => $this->paymentMethod->name
            ],
            'subtotal' => (float) $this->subtotal,
            'discount' => (float) $this->discount,
            'total' => (float) $this->total,
            'order_products' => OrderProductResource::collection($this->whenLoaded('orderProducts')),
        ];
    }
}
