<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];
    
    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }
}
