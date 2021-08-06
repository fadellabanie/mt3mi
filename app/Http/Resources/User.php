<?php

namespace App\Http\Resources;

use App\Http\Resources\Attendance as AttendanceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'dial_code' => $this->dial_code,
            'phone' => $this->phone,
            'employee_number' => $this->employee_number,
            'username' => $this->username,
            'business_role' => $this->business_role,
            'language' => $this->language,
            'attendance' => new AttendanceResource($this->whenLoaded('lastAttendance')),
        ];
    }
}
