<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            "code" => $this->code,
            "type" => $this->type,
            "value" => $this->value,
            "valid_from" => $this->valid_from,
            "valid_to" => $this->valid_to,
            "from_time" => $this->from_time,
            "to_time" => $this->to_time,
            "is_active" => $this->is_active,
            "is_used" => $this->is_used,
            'coupon_days' => $this->couponDays->map(function ($item) {
                return [
                    'day' => $item->day,
                ];
            })
        ];
    }
}
