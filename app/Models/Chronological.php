<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chronological extends Model
{
    protected $table = "chronologicals";
	protected $primaryKey = "chId";
    protected $fillable = ['chAcademicperiod_id','chRangeWeek','chNumberWeek','chCourse_id','chIntelligence_id','chCollaborator_id','chBases'];
	public $timestamps = false;
}
