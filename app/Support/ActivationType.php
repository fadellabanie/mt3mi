<?php

namespace App\Support;

class ActivationType
{
    public static function types()
    {
        return collect([
            [
                'key' => 'call-center',
                'name' => 'Call center',
            ],
            [
                'key' => 'cashier',
                'name' => 'Cashier',
            ],
        ]);
    }
}