<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];

    const PAID = 'PAID';
    const NOT_PAID = 'NOT PAID';


    const LEVELS = [
        '1hr' => 3,
        '3hr' => 4.5,
        '6hr' => 6.7,
        'ALL_DAY' => 10.0
    ];

    public function adjustTicketLevel($newLevel)
    {
        $this->fill([
            'current_level' => $newLevel,
            'owing' => self::LEVELS[$newLevel]
        ]);
    }
}
