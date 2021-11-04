<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Course;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->jobTitle,
        'grade_id' => rand(1,50),
    ];
});
