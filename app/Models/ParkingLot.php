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
    public function getIsEmptyAttribute()
    {
        return $this->capacity == 0;
    }

    public function getIsFullAttribute()
    {
        return $this->current_ticket_count >=  $this->capacity;
    }


    public function newTicket($userId)
    {
        if ($this->isFull) {
            throw new \App\Exceptions\ParkingLotFullException('The parking lot is full!');
        }

        $ticket = $this->tickets()->create(['parking_lot_id' => $this->id, 'user_id' => $userId]);
        $this->increment('current_ticket_count');

        return $ticket;
    }
}
