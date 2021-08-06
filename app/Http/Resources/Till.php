<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Till extends JsonResource
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
            'opened_at' => (string) $this->opened_at,
            'closed_at' => (string) $this->closed_at
        ];
    }
}
