<?php

namespace App\Http\Requests\API;

use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function createAttendance()
    {
        Attendance::create([
            'restaurant_id' => auth()->user()->restaurant_id,
            'user_id' => $this->user_id,
            'check_in' => Carbon::now()
        ]);
    }
}
