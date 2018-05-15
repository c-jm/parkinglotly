<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingLot extends Model
{    
    protected $guarded = [];
    protected $table = 'parking_lots';

    public function getIsEmptyAttribute()
    {
        return $this->capacity == 0;
    }
}
