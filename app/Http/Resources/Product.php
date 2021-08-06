<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductModifier as ProductModifierResource;
use App\Http\Resources\Tag as TagResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductSize as ProductSizeResource;

class Product extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'preparation_time' => $this->preparation_time,
            'image' => ($this->image) ? url('storage/' . $this->image) : '',
            'is_combo' => (bool) $this->is_combo,
            'tags' => TagResource::collection($this->tags),
            'sizes' => ProductSizeResource::collection($this->productSizes),
            'modifiers' => ProductModifierResource::collection($this->productModifiers),
        ];
    }
}
