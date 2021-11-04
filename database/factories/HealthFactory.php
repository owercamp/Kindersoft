<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Health;
use Faker\Generator as Faker;

$factory->define(Health::class, function (Faker $faker) {
	$valuetypes = ['EPS','PREPAGADA'];
    return [
        'entity' => $faker->company,
        'type' => $valuetypes[rand(0,1)],
    ];
});
