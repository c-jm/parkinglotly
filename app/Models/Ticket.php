<?php

namespace App\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    
    public function getOwingLevelAttribute()
    {
        return OwingLevel::get($this->currentTicketTimeLevelKey());
    }

    public function getOwingMessageAttribute()
    {
        return sprintf("Ticket owes: $%.2f for timespan of: %s", $this->owingLevel['owing'], $this->owingLevel['key']);
    }


    public function pay($chargeId)
    {
        if ($this->payment) {
            return null;
        }

        $owing = $this->owingLevel;

        $payment = $this->payment()->create(['name' => $this->user->name,
                                       'stay_length' => $this->owingLevel['key'],
                                       'paid_amount' => $this->owingLevel['owing'],
                                       'charge_id' => bcrypt($chargeId)]);

        $this->payment()->associate($payment);
        $this->user()->dissociate();
        $this->save();

        return $payment;
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
