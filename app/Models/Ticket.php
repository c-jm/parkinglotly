<?php

namespace App\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];

    const PAID = 'PAID';
    const NOT_PAID = 'NOT PAID';


    const LEVELS = [
        ['key' => '1hr', 'owing' => 3.00],
        ['key' => '3hr', 'owing' => 4.50],
        ['key' => '6hr', 'owing' => 6.70],
        ['key' => 'ALL_DAY', 'owing' => 10.00]
    ];


    public static function getLevel($key) 
    {
        return collect(static::LEVELS)->firstWhere('key', $key);
    }

    private function currentTicketTimeDifference()
    {
        $now = Carbon::now();
        $diff = $now->diffInHours($this->created_at);

        if ($diff <= 1) {
            return '1hr';       
        } 
        
        if ($diff <= 3) {
            return '3hr';
        }

        if ($diff <= 6) {
            return '6hr';
        }

        return 'ALL_DAY';
    } 

    public function getOwingLevelAttribute()
    {
        $key = $this->currentTicketTimeDifference();

        return static::getLevel($key);
    }

    public function owes()
    {
        $owingLevel = $this->owingLevel;

        return sprintf("Ticket owes: $%.2f for timespan of: %s", $owingLevel['owing'], $owingLevel['key']);
    }
 
    public function adjustTicketLevel($newLevel)
    {
        $this->fill([
            'current_level' => $newLevel,
            'owing' => self::LEVELS[$newLevel]
        ]);
    }
}
