<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Period;
use Faker\Generator as Faker;

$factory->define(Period::class, function (Faker $faker) {
    return [
       	'name' => $faker->name,
       	'grade_id' => rand(1,50),
       	'initialDate' => $faker->date($format = 'd-m-Y'),
       	'finalDate' => $faker->date($format = 'd-m-Y'),
    ];
});