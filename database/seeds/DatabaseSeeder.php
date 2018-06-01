<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(ParkingLotSeeder::class);
        $this->call(UserSeeder::class);
    }
}
