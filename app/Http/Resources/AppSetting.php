<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppSetting extends JsonResource
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
            'order_type' => [
                'id' => (int) $this->orderType->id,
                'name' => $this->orderType->name,
            ],
            'logout_inactive_after' => (int) $this->logout_inactive_after,
            'reset_order_number_after' => (int) $this->reset_order_number_after ,
            'void_require_customer_info' => (bool) $this->void_require_customer_info,
            'discount_require_customer_info' => (bool) $this->discount_require_customer_info,
            'run_in_submode' => (bool) $this->run_in_submode,
            'receipt_language' => $this->receipt_language,
            'waiter_app_background' => (string) asset('storage/' . $this->waiter_app_background),
            'cashier_app_background' => (string) asset('storage/' . $this->cashier_app_background),
            'customer_app_background' => (string) asset('storage/' . $this->customer_app_background),
            'receipt_logo' => (string) asset('storage/' . $this->receipt_logo),
            'receipt_header' => (string) $this->receipt_header,
            'receipt_footer' => (string) $this->receipt_footer,
        ];
    }
}
