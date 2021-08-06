<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
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
            "name" => $this->name,
            "type" => $this->type,
            "value" => $this->value,
            "applies_to" => $this->applies_to,
            "activate_for" => $this->activate_for,
            "is_taxable" => $this->is_taxable,
            "start_date" => $this->start_date,
        ];
    }
}
