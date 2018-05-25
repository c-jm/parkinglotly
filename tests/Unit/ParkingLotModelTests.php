<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Models\ParkingLot;

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
        $parkingLot = factory(ParkingLot::class)->create(['capacity' => 1]);
        $user = factory(User::class)->create();

        $parkingLot->newTicket($user->id);

        $this->assertTrue($parkingLot->isFull);
    }

    public function test_that_parking_lots_issue_tickets_when_space_is_available()
    {
        $parkingLot = factory(ParkingLot::class)->create(['capacity' => 10]);
        $user = factory(User::class)->create();

        $ticket = $parkingLot->newTicket($user->id);

        $this->assertEquals($parkingLot->id, $ticket->parking_lot_id);    
    }
    
    public function test_that_parking_lots_return_a_parking_lot_full_exception_when_full()
    {
        $this->expectException(\App\Exceptions\ParkingLotFullException::class);

        $parkingLot = factory(ParkingLot::class)->create(['capacity' => 0]);
        $user = factory(User::class)->create();

        $parkingLot->newTicket($user->id);
    }
}
