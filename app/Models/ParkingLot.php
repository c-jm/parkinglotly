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

    public function newTicket($userId)
    {
        if ($this->isFull) {
            throw new \App\Exceptions\ParkingLotFullException('The parking lot is full!');
        }
        return  $this->tickets()->create();
    }
}
