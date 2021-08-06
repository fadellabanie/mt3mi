<?php

namespace App\Http\Requests\API;

use App\Models\Till;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTillOperationRequest extends FormRequest
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
        return [
            'type' => ['required', Rule::in(['pay_in', 'pay_out', 'cash_drop'])],
            'amount' => 'required|numeric',
            'note' => 'nullable|string',
        ];
    }

    public function createOperation(Till $till)
    {
        $till->operations()->create([
            'type' => $this->type,
            'amount' => $this->amount,
            'note' => $this->note
        ]);
    }
}
