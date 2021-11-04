<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Profession;
use Faker\Generator as Faker;

$factory->define(Profession::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->jobTitle(7),
    ];
});
