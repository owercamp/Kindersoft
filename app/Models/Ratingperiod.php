<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ratingperiod extends Model
{
    protected $table = "ratingsPeriod";
	protected $primaryKey = "rpId";
    protected $fillable = [
    	'rpStudent_id',
    	'rpAcademicperiod_id',
    	'rpWeight_one',
    	'rpHeight_one',
    	'rpObservation_one',
    	'rpWeight_two',
    	'rpHeight_two',
    	'rpObservation_two',
    	'rpHealtear',
    	'rpHealteye',
    	'rpHealthoral',
    	'rpVaccinations',
    	'rpObservationshealth',
    	'rpProfessionaslhealth'
    ];
	public $timestamps = false;
}
