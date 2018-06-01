<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function leave(Request $request)
    {
        $rules = [
            'user_id' => 'required'
        ];

        $request->validate($rules);

        $userId = $request->input('user_id');

        $user = User::find($userId);

        if (! $user) {
            return response()->json(['error' => sprintf("No user could be found with id: %d", $userId)], 422);
        }

        if (! $user->ticket) {
            return response()->json(['error' => 'No current ticket issued'], 422);
        }

        if (! $user->ticket->payment) {
            return response()->json(['error' => 'Please pay your ticket before you try to leave'], 422);
        }

        $user->ticket->removeUser();

        return response()->json(['message' => sprintf("Thanks %s for visiting the parking lot!", $user->name)], 200);
    }
}
