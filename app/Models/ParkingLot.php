<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingLot extends Model
{
    protected $guarded = [];
    protected $table = 'parking_lots';

    // Relations
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Attributes
    public function getIsFullAttribute()
    {
        return $this->tickets()->whereNull('payment_id')->count() >=  $this->capacity;
    }

    public function newTicket($user)
    {
        if ($this->isFull) {
            throw new \App\Exceptions\ParkingLotFullException('The parking lot is full!');
        }

        $ticket = $this->tickets()->create();
        $user->assignTicket($ticket);

        return $ticket;
    }
}
