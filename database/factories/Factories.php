<?php

use Faker\Generator as Faker;

use App\Models\Ticket;
use App\Models\ParkngLot;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

// @

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Models\ParkingLot::class, function(Faker $faker) {
    return [
        'name' => $faker->company,
        'current_ticket_count' => 0,
        'capacity' => 50
    ];
});

$factory->define(\App\Models\Ticket::class, function(Faker $faker) {
    return [
        'paid_status' => Ticket::PAID,
        'current_level' => '1hr',
        'owing' => Ticket::getLevel('1hr')['owing']
    ];
});