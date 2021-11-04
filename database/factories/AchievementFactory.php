<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Achievement;
use Faker\Generator as Faker;

$factory->define(Achievement::class, function (Faker $faker) {
    return [
    	'name' => $faker->name,
        'description' => $faker->unique()->text(50),
        'intelligence_id' => rand(1,30),
    ];
});
