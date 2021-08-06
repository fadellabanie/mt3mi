<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserExport implements FromCollection, WithHeadings, ShouldAutoSize, Withmapping
{
    public function headings(): array
    {
        return [
            'Name',
            'Type',
            'Dial Code',
            'Phone',
            'Email',
            'Employee Number',
            'Salary',
            'Business_role',
            'Language',
            'Created At',
        ];
    }

    public function collection()
    {
        return User::restaurant()
            ->select(
                'name',
                'type',
                'dial_code',
                'phone',
                'email',
                'employee_number',
                'salary',
                'business_role',
                'language',
                'created_at'
            )->get();
    }


    public function map($user): array
    {
        return [
            $user->name,
            $user->type,
            $user->dial_code,
            $user->phone,
            $user->email,
            $user->employee_number,
            $user->salary,
            $user->business_role,
            $user->language,
            $user->created_at->toDateTimeString(),
        ];
    }
}
