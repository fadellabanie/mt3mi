<?php

namespace App\Http\Requests\API;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWasteProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $table = 'inventory_items';

        if (in_array($this->type, ['product', 'modifier', 'item'])) {
            $table = $this->table();
        }

        return [
            'id' => ['required', Rule::exists($table, 'id')],
            'type' => ['required', Rule::in(['product', 'modifier', 'item'])],
            'quantity' => 'required|integer',
            'note' => 'nullable|string'
        ];
    }

    public function table()
    {
        return [
            'item' => 'inventory_items',
            'product' => 'product_sizes',
            'modifier' => 'modifier_options'
        ][$this->type];
    }
}
