<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Attendant;
use Faker\Generator as Faker;

$factory->define(Attendant::class, function (Faker $faker) {
    return [
        'typedocument_id' => rand(1,50),
        'numberdocument' => rand(999999,9999999),
        'firstname' => $faker->name,
        'secondname' => $faker->name,
        'threename' => $faker->name,
        'fourname' => $faker->name,
        'address' => $faker->streetAddress,
        'cityhome_id' => rand(1,30),
        'locationhome_id' => rand(1,30),
        'districthome_id' => rand(1,30),
        'phoneone' => $faker->e164PhoneNumber,
        'phonetwo' => $faker->e164PhoneNumber,
        'whatsapp' => $faker->e164PhoneNumber,
        'emailone' => $faker->email,
        'emailtwo' => $faker->freeEmail,
        'bloodtype_id' => rand(1,11),
        'gender' => $this->genderToAttendant(),
        'profession_id' => rand(1,30),
        'company' => $faker->company,
    	'position' => $faker->jobTitle,
    	'antiquity' => rand(10,365),
    	'addresscompany' => $faker->address,
    	'citycompany_id' => rand(1,30),
    	'locationcompany_id' => rand(1,30),
    	'dictrictcompany_id' => rand(1,30),
    ];
});

function genderToAttendant($number = 0){
	if($number = 0){
		$number = rand(1,3);
	}
	switch ($number) {
		case 1:
			return 'MASCULINO';
			break;
		case 2:
			return 'FEMENINO';
			break;
		case 3:
			return 'INDEFINIDO';
			break;
	}
}
