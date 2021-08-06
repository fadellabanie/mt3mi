<?php

namespace App\Support;

class ApplyType
{
    public static function types()
    {
        return collect([
            [
                'key' => 'tags',
                'name' => 'Tags',
            ],
            [
                'key' => 'products',
                'name' => 'Products',
            ],
            [
                'key' => 'categories',
                'name' => 'Categories',
            ],
            [
                'key' => 'orders',
                'name' => 'Orders',
            ],
        ]);
    }
}