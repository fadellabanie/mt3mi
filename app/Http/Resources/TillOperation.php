<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TillOperation extends JsonResource
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
            'business_date' => $this->business_date,
            'type' => $this->type,
            'amount' => $this->amount,
            'note' => (string) $this->note,
        ];
    }
}
