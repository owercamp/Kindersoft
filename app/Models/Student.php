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

    public $timestamps = false;

    public function weektrackings(){
        return $this->hasMany(Weeklytracking::class,'wtStudent_id');
    }
}
