<?php

use Illuminate\Database\Seeder;

class ParkingLotSeeder extends Seeder
{
    public function run()
    {
        factory(App\Models\ParkingLot::class)->create();
    }
}
