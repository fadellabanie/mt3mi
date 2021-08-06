<?php

namespace App\Imports;

use Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UserImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    SkipsOnFailure,
    WithBatchInserts,
    WithChunkReading
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new User([
            'restaurant_id' => auth()->user()->restaurant_id,
            'name'     => $row['name'],
            'type'     => $row['type'],
            'dial_code' => $row['dial_code'],
            'phone'    => $row['phone'],
            'email'    => $row['email'],
            'employee_number' => $row['employee_number'],
            'username' => $row['username'],
            'password' => Hash::make($row['password']),
            'pin_code' => $row['pin_code'],
            'salary' => $row['salary'],
            'business_role' => $row['business_role'],
            'language' => $row['language'],
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return config('excel.exports.chunk_size');
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required|string|max:25',
            '*.type' => 'required',
            '*.dial_code' => 'required',
            '*.phone' => ['required', 'max:15'],
            '*.email' => 'nullable|string|email|max:255|required_unless:type,app user',
            '*.employee_number' => 'nullable',
            '*.username' => 'nullable|string|alpha_dash|required_if:type,app user',
            '*.password' => 'nullable|min:8|required_unless:type,app user',
            '*.language' => 'nullable',
            '*.salary' => 'nullable|numeric',
            '*.business_role' => 'nullable|string|min:3|max:25',
            '*.pin_code' => 'nullable|max:4|required_if:type,app user',
        ];
    }
}
