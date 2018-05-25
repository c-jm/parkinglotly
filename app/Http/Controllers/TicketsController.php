<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\ParkingLot;


use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function create(ParkingLot $lot, Request $request)
    {
        $rules = [
            'userId' => 'required|bail'
        ];

        $request->validate($rules);
        
        $userId = $request->input('userId');

        // @NOTE(cjm): Use findOrFail here?
        $user = User::find($userId);

        if (! $user) {
            return response()->json(['error' => sprintf('No user found with id: %d', $userId)], 422);
        }

        $ticket = $lot->newTicket($userId);

        return response()->json(['message' => sprintf("Your ticket number is: %d", 1)], 201);
    }

    public function show(ParkingLot $lot, $ticketId) 
    {
        if (! $ticket = $lot->tickets()->find($ticketId)) {
            return response()->json(['error' => sprintf("No ticket with id: %d in lot: %d", $lot->id, $ticketId)], 422);
        }

        return response()->json(['message' => $ticket->owingMessage], 200);
    }
}
