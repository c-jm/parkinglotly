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
        $this->assertTrue($parkingLot->is_empty); 
    }
}
