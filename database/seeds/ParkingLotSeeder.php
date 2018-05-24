<?php

use Illuminate\Database\Seeder;

class ParkingLotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\ParkingLot::class)->create(['capacity' => 1]);
    }
} 