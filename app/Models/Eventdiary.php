<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventdiary extends Model
{
    protected $table = "eventDiary";
	protected $primaryKey = "edId";
    protected $fillable = [
    		'edDate',
    		'edStart',
    		'edEnd',
    		'edCollaborator_id',
    		'edCreation_id',
    		'edStudents',
    		'edDescription',
    		'edDescriptionout',
    		'edStatus',
    		'edColor'
    	];
	public $timestamps = false;
}
