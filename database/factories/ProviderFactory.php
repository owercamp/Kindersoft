<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Provider;
use Faker\Generator as Faker;

$factory->define(Provider::class, function (Faker $faker) {
    return [
        'typedocument_id' => rand(1,50),
        'numberdocument' => rand(999999,9999999),
        'numbercheck' => rand(1,4),
        'namecompany' => $faker->company,
        'address' => $faker->streetAddress,
        'cityhome_id' => rand(1,30),
        'locationhome_id' => rand(1,30),
        'districthome_id' => rand(1,30),
        'phoneone' => $faker->e164PhoneNumber,
        'phonetwo' => $faker->e164PhoneNumber,
        'whatsapp' => $faker->e164PhoneNumber,
        'emailone' => $faker->email,
        'emailtwo' => $faker->freeEmail,
    ];
});
