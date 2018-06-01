<?php

namespace Tests\Feature;

use App\Models\ParkingLot;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeaveControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_if_a_user_doesnt_exist_and_tries_to_leave_an_error_is_thrown()
    {
        $user = factory(User::class)->make(['id' => 1]);
        $uri = '/api/leave';
        $response = $this->json('POST', $uri, ['user_id' => $user->id]);

        $response->assertStatus(422)->assertJson(['error' => sprintf("No user could be found with id: %d", $user->id)]);
    }

    public function test_that_if_a_user_tries_to_leave_without_a_ticket_we_return_that_to_them()
    {
        $user = factory(User::class)->create();

        $uri = '/api/leave';

        $response = $this->json('POST', $uri, ['user_id' => $user->id]);

        $response->assertJson(['error' => 'No current ticket issued'])->assertStatus(422);
    }

    public function test_that_a_user_cant_leave_without_making_a_payment()
    {
        $lot = factory(ParkingLot::class)->create();
        $user = factory(User::class)->create();

        $lot->newTicket($user);

        $uri = '/api/leave';

        $response = $this->json('POST', $uri, ['user_id' => $user->id]);
        $response->assertJson(['error' => 'Please pay your ticket before you try to leave'])->assertStatus(422);
    }

    public function test_that_a_user_can_leave_with_a_paid_ticket()
    {
        $lot = factory(ParkingLot::class)->create();
        $user = factory(User::class)->create();

        $ticket = $lot->newTicket($user);
        $ticket->pay('abcabcabcabc');

        $uri = '/api/leave';

        $response = $this->json('POST', $uri, ['user_id' => $user->id]);
        $response->assertJson(['message' => sprintf("Thanks %s for visiting the parking lot!", $user->name)])->assertStatus(200);
    }
}
