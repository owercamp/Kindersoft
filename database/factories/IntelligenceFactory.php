<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Intelligence::class, function (Faker $faker) {
    return [
        'type' => $faker->unique()->jobTitle,
        'description' => $faker->text(90),
    ];
});
