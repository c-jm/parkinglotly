<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\ParkingLot;
use \LVR\CreditCard\CardNumber;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function create(Request $request, ParkingLot $lot, $ticketId)
    {
        $rules = [
            'credit_card_number' => ['required', new CardNumber]
        ];

        $request->validate($rules);

        $ticket = $lot->tickets()->find($ticketId);
        if (! $ticket) {
            return response()->json(['message' => sprintf("Ticket with id: %d in lot: %d not found", $ticketId, $lot->id)], 422);
        }

        $creditCard = $request->input('credit_card_number');
        
        $payment = $ticket->pay($creditCard);
        if (! $payment) {
            return response()->json(['error' => sprintf("Ticket with id: %d in lot: %d has already been paid for", $ticketId, $lot->id)]);
        }

        $lot->removeTicket($ticket);
        
        return response()->json(['payment' => $payment], 201);
    }
}
