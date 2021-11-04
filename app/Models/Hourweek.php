<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hourweek extends Model
{
    protected $table = "hoursweek";
	protected $primaryKey = "hwId";
    protected $fillable = ['hwDate','hwHourInitial','hwHourFinal','hwDay','hwActivityClass_id','hwActivitySpace_id','hwCollaborator_id','hwCourse_id','hwStatus'];
	public $timestamps = false;
}
