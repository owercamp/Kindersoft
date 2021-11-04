<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'typedocument_id' => rand(1,50),
        'numberdocument' => rand(999999,9999999),
        'firstname' => $faker->name,
        'secondname' => $faker->name,
        'threename' => $faker->name,
        'fourname' => $faker->name,
        'birthdate' => $faker->date($format = 'd-m-Y'),
        'yearsold' => rand(1,10),
        'address' => $faker->streetAddress,
        'cityhome_id' => rand(1,30),
        'locationhome_id' => rand(1,30),
        'districthome_id' => rand(1,30),
        'bloodtype_id' => rand(1,11),
        'gender' => $this->genderToStudent(),
        'health_id' => rand(1,10),
        'additionalHealt' => $this->healtTo(),
        'additionalHealtDescription' => $faker->text(100),
    ];
});

function genderToStudent($number = 0){
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

function healtTo($number = 0){
	if($number = 0){
		$number = rand(1,2);
	}
	switch ($number) {
		case 1:
			return 'SI';
			break;
		case 2:
			return 'NO';
			break;
	}
}