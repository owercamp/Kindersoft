<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\District;
use Faker\Generator as Faker;

$factory->define(District::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'location_id' => rand(1,50),
    ];
});
