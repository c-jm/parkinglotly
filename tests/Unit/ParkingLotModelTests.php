<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ParkingLot;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParkingLotTests extends TestCase
{
    use RefreshDatabase;

    public function test_that_parking_lots_return_full_appropriately_when_at_capacity()
    {
        $parkingLot = factory(ParkingLot::class)->create(['capacity' => 0]);

        $this->assertTrue($parkingLot->isFull);
    }

    public function test_that_parking_lots_return_full_appropriately_when_over_capacity()
    {
        $lot = factory(ParkingLot::class)->create(['capacity' => 1]);

        $lot->newTicket();

        $this->assertTrue($lot->isFull);
    }

    public function test_that_parking_lots_issue_tickets_when_space_is_available()
    {
        $parkingLot = factory(ParkingLot::class)->create(['capacity' => 10]);

        $ticket = $parkingLot->newTicket();

        $this->assertEquals($parkingLot->id, $ticket->parking_lot_id);
        $this->assertDatabaseHas('tickets', $ticket->getAttributes());
    }
    
    public function test_that_parking_lots_return_a_parking_lot_full_exception_when_full()
    {
        $this->expectException(\App\Exceptions\ParkingLotFullException::class);

        $lot = factory(ParkingLot::class)->create(['capacity' => 0]);
        $lot->newTicket();
    }
}
