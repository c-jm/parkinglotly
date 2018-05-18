<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ParkingLot;

class ParkingLotTests extends TestCase
{
    public function test_that_parking_lots_return_empty_on_capacity_0()
    {
        $parkingLot = factory(ParkingLot::class)->make(['capacity' => 0]);
        $this->assertTrue($parkingLot->isEmpty); 
    }

    public function test_that_parking_lots_return_full_appropriately_when_at_capacity()
    {
        $parkingLot = factory(ParkingLot::class)->make(['capacity' => 50, 'current_ticket_count' => 50]);
        $this->assertTrue($parkingLot->isFull);
    }


    public function test_that_parking_lots_return_full_appropriately_when_over_capacity()
    {
        $parkingLot = factory(ParkingLot::class)->make(['capacity' => 50, 'current_ticket_count' => 51]);
        $this->assertTrue($parkingLot->isFull);
    }

    public function test_that_parking_lots_issue_tickets_when_space_is_available()
    {
        $parkingLot = factory(ParkingLot::class)->create(['capacity' => 10, 'current_ticket_count' => 0]);
        
        $ticket = $parkingLot->newTicket('1hr');

        $this->assertEquals($parkingLot->id, $ticket->parking_lot_id);
        $this->assertEquals(1, $parkingLot->current_ticket_count);
        $this->assertEquals('UNPAID', $ticket->paid_status);
    
    }
    
    public function test_that_parking_lots_return_a_parking_lot_full_exception_when_full()
    {
        $this->expectException(\App\Exceptions\ParkingLotFullException::class);

        $parkingLot = factory(ParkingLot::class)->create(['capacity' => 50, 'current_ticket_count' => 50]);
        $parkingLot->newTicket('3hr');
    }

}
