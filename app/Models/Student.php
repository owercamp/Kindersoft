<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
	protected $table = "students";

	protected $fillable = [
		'id',
		'typedocument_id',
		'numberdocument',
		'photo',
		'firstname',
		'threename',
		'fourname',
		'birthdate',
		'yearsold',
		'address',
		'cityhome_id',
		'locationhome_id',
		'dictricthome_id',
		'bloodtype_id',
		'gender',
		'health_id',
		'additionalHealt',
		'additionalHealtDescription'
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'id' => 'integer',
		'typedocument_id' => 'integer',
		'numberdocument' => 'string',
		'photo' => 'string',
		'firstname' => 'string',
		'threename' => 'string',
		'fourname' => 'string',
		'birthdate' => 'date',
		'yearsold' => 'string',
		'address' => 'string',
		'cityhome_id' => 'integer',
		'locationhome_id' => 'integer',
		'dictricthome_id' => 'integer',
		'bloodtype_id' => 'integer',
		'gender' => 'string',
		'health_id' => 'integer',
		'additionalHealt' => 'string',
		'additionalHealtDescription' => 'string'
	];

	public $timestamps = false;

	public function weektrackings()
	{
		return $this->hasMany(Weeklytracking::class, 'wtStudent_id');
	}

	/**
	 * Get the student
	 *
	 * @param  string
	 * @return string
	 */
	public function getfullnameAttribute()
	{
		return $this->firstname." ".$this->threename." ".$this->fourname;
	}
}
