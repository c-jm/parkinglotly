<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\ParkingLot;
use App\Models\Ticket;
use \Carbon\Carbon;

class TicketModelTest extends TestCase
{
    public function test_that_a_ticket_returns_correct_level_for_payment()
    {
        $ticket = factory(Ticket::class)->make(['created_at' => Carbon::now()->addHours(0.2)]);        
        $this->assertEquals(Ticket::getLevel('1hr'), $ticket->owingLevel);

        $ticket = factory(Ticket::class)->make(['created_at' => Carbon::now()->addHours(2)]);
        $this->assertEquals(Ticket::getLevel('3hr'), $ticket->owingLevel);

        $ticket = factory(Ticket::class)->make(['created_at' => Carbon::now()->addHours(6)]);
        $this->assertEquals(Ticket::getLevel('6hr'), $ticket->owingLevel);

        $ticket = factory(Ticket::class)->make(['created_at' => Carbon::now()->addHours(7)]);
        $this->assertEquals(Ticket::getLevel('ALL_DAY'), $ticket->owingLevel);
    }
}