<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Location::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'city_id' => rand(1,50),
    ];
});
