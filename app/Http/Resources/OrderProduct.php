<?php

namespace App\Http\Resources;

use App\Http\Resources\OrderProductModifier as OrderProductModifierResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProduct extends JsonResource
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
            'product_size' => [
                'id' => $this->id,
                'name' => $this->productSize->name,
                'product' => [
                    'id' => $this->productSize->product->id,
                    'name' => $this->productSize->product->name
                ]
            ],
            'quantity' => (int) $this->quantity,
            'price' => (float) $this->price,
            'total' => (float) $this->total,
            'modifiers' => OrderProductModifierResource::collection($this->orderProductModifiers)
        ];
    }
}
