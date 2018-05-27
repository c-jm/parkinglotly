<?php

namespace App\Models;

class OwingLevel
{
    const LEVELS = [
        ['key' => '1hr', 'owing' => 3.00],
        ['key' => '3hr', 'owing' => 4.50],
        ['key' => '6hr', 'owing' => 6.70],
        ['key' => 'ALL_DAY', 'owing' => 10.00]
    ];

    public static function get($key)
    {
        return collect(static::LEVELS)->firstWhere('key', $key);
    }
}
