<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Bloodtype;
use Faker\Generator as Faker;

$factory->define(Bloodtype::class, function (Faker $faker) {
    return [
        'group' => $faker->group,
        'type' => $faker->type
    ];
});
