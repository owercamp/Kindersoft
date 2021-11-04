<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weeklytracking extends Model
{
    protected $table = "weeklytrackings";
	protected $primaryKey = "wtId";
    protected $fillable = ['wtCourse_id','wtPeriod_id','wtChronological_id','wtStudent_id','wtBaseactivity_id','wtIntelligence_id','wtAchievement_id','wtNote','wtStatus'];
	public $timestamps = false;
}
