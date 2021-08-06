<?php

namespace App\Http\Resources;

use App\Http\Resources\Product as ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
            'icon' => ($this->icon) ? url('storage/' . $this->icon) : '',
            'products' => ProductResource::collection($this->products)
        ];
    }
}
