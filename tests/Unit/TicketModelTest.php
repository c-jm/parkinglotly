<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\ParkingLot;
use App\Models\Ticket;

class TicketModelTest extends TestCase
{

    public function test_that_a_ticket_can_be_adjusted_correctly()
    {
        $parking = factory(ParkingLot::class)->create();
        $ticket = factory(Ticket::class)->create(['parking_lot_id' => $parking->id]);
        $this->assertEquals(3, $ticket->owing);

        $ticket->adjustTicketLevel('3hr');
        $ticket = $ticket->fresh();
        
        $this->assertEquals(4.5, $ticket->owing);
        $this->assertEquals('3hr', $ticket->current_level);   
    }
}