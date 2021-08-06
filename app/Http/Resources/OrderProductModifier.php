<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductModifier extends JsonResource
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
            'modifier_option' => [
                'id' => $this->modifierOption->id,
                'name' => $this->modifierOption->name,
                'modifier' => [
                    'id' => $this->modifierOption->modifier->id,
                    'name' => $this->modifierOption->modifier->name
                ]
            ],
            'quantity' => (int) $this->quantity,
            'price' => (float) $this->price,
            'total' => (float) $this->total,
        ];
    }
}
