<?php

namespace App\Http\Resources;

use App\Http\Resources\ModifierOption as ModifierOptionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductModifier extends JsonResource
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
            'minimum_options' => $this->minimum_options,
            'maximum_options' => $this->maximum_options,
            'name' => $this->modifier->name,
            'is_multiple' => $this->modifier->is_multiple,
            'options' => ModifierOptionResource::collection($this->modifier->modifierOptions),
        ];
    }
}
