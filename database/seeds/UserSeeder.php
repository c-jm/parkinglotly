<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(range(1, 3))->each(function ($value) {
            factory(\App\Models\User::class)->create();
        });
    }
}
