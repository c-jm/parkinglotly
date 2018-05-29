<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }

    public function assignTicket($ticket)
    {
        return $this->ticket()->save($ticket);
    }
}
