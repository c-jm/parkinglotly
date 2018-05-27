<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use \App\Models\ParkingLot;
use \App\Models\User;

class TicketsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_when_tickets_create_endpoint_is_hit_a_ticket_is_created()
    {
        $lot = factory(ParkingLot::class)->create();
        $user = factory(User::class)->create();

        $uri = sprintf("/api/lots/%d/tickets", $lot->id);
        $response = $this->json('POST', $uri, ['user_id' => $user->id ]);

        $response->assertStatus(201)->assertJson(['message' => sprintf("Your ticket number is: %d", $user->id)]);
    }

    public function test_that_when_tickets_create_endpoint_is_hit_with_non_existant_user_an_error_is_thrown()
    {
        $lot = factory(ParkingLot::class)->create();

        $uri = sprintf("/api/lots/%d/tickets", $lot->id);
        $response = $this->json('POST', $uri, ['user_id' => 1]);
        
        $response->assertStatus(422)->assertJson(['error' => sprintf("No user found with id: %d", 1)]);
    }

    public function test_that_when_tickets_show_endpoint_is_hit_a_ticket_is_shown()
    {
        $lot = factory(ParkingLot::class)->create();
        $user = factory(User::class)->create();
        $ticket = $lot->newTicket($user->id);

        $uri = sprintf('/api/lots/%d/tickets/%d', $lot->id, $ticket->id);
        $response = $this->json('GET', $uri);

        $response->assertStatus(200)->assertJson(['message' => $ticket->owingMessage]);
    }

    public function test_that_when_tickets_show_endpoint_is_hit_with_no_valid_ticket_id_throw_an_error()
    {
        $lot = factory(ParkingLot::class)->create();

        $uri = sprintf('/api/lots/%d/tickets/%d', $lot->id, 1);
        $response = $this->json('GET', $uri);

        $response->assertStatus(422)->assertJson(['error' => sprintf("No ticket with id: %d in lot: %d", $lot->id, 1)]);
    }
}
