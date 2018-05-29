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
            'user_id' => 'required'
        ];

        $request->validate($rules);
        
        $userId = $request->input('user_id');

        // @NOTE(cjm): Use findOrFail here?
        $user = User::find($userId);
        if (! $user) {
            return response()->json(['error' => sprintf('No user found with id: %d', $userId)], 422);
        }
        
        if ($user->ticket) {
            return response()->json(['error' => sprintf("User already has ticket with number: %d", $user->ticket->id)]);
        }

        $ticket = $lot->newTicket($userId);
        $user->ticket()->save($ticket);

        return response()->json(['message' => sprintf("Your ticket number is: %d", $ticket->id)], 201);
    }

    public function show(ParkingLot $lot, $ticketId)
    {
        if (! $ticket = $lot->tickets()->find($ticketId)) {
            return response()->json(['error' => sprintf("No ticket with id: %d in lot: %d", $lot->id, $ticketId)], 422);
        }

        return response()->json(['message' => $ticket->owingMessage], 200);
    }
}
