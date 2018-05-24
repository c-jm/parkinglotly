<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


use \Carbon\Carbon;
use App\Models\Ticket;
use App\Models\ParkingLot;
use App\Models\OwingLevel;

class TicketModelTest extends TestCase
{
    public function test_that_a_ticket_returns_correct_level_for_payment()
    {
        $ticket = factory(Ticket::class)->make(['created_at' => Carbon::now()->addHours(0.2)]);        
        $this->assertEquals(OwingLevel::get('1hr'), $ticket->owingLevel);

        $ticket = factory(Ticket::class)->make(['created_at' => Carbon::now()->addHours(2)]);
        $this->assertEquals(OwingLevel::get('3hr'), $ticket->owingLevel);

        $ticket = factory(Ticket::class)->make(['created_at' => Carbon::now()->addHours(6)]);
        $this->assertEquals(OwingLevel::get('6hr'), $ticket->owingLevel);

        $ticket = factory(Ticket::class)->make(['created_at' => Carbon::now()->addHours(7)]);
        $this->assertEquals(OwingLevel::get('ALL_DAY'), $ticket->owingLevel);
    }
}