<?php

namespace App\Support;

class WeekDay
{
    public static function days()
    {
        return collect( [
            [
                'abbr' => 'Sat',
                'name' => 'Saturday',
            ],
            [
                'abbr' => 'Sun',
                'name' => 'Sunday',
            ],
            [
                'abbr' => 'Mon',
                'name' => 'Monday',
            ],
            [
                'abbr' => 'Tue',
                'name' => 'Tuesday',
            ],
            [
                'abbr' => 'Wed',
                'name' => 'Wednesday',
            ],
            [
                'abbr' => 'Thu',
                'name' => 'Thursday',
            ],
            [
                'abbr' => 'Fri',
                'name' => 'Friday',
            ],
        ]);
    }
}