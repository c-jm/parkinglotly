<?php

namespace App\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];

    const PAID = 'PAID';
    const NOT_PAID = 'NOT PAID';

    
    public function getOwingLevelAttribute()
    {
        return OwingLevel::get($this->currentTicketTimeLevelKey());
    }

    public function getOwingMessageAttribute()
    {
        return sprintf("Ticket owes: $%.2f for timespan of: %s", $this->owingLevel['owing'], $this->owingLevel['key']);
    }
    

    private function currentTicketTimeLevelKey()
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

}
