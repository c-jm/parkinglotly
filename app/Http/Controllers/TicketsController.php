<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

use App\Models\ParkingLot;


use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function create(ParkingLot $lot)
    {
        $ticket = $lot->newTicket();
        return response()->json(['message' => 'Your ticket number is: ' . $ticket->id], 201);
    }

    public function show(ParkingLot $lot, Ticket $ticket) 
    {
        return response()->json(['message' => $ticket->owes()]);
    }
}
