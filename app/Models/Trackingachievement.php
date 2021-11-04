<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trackingachievement extends Model
{
    protected $table = "trackingachievements";
	protected $primaryKey = "taId";
    protected $fillable = ['taCourse_id','taPeriod_id','taStudent_id','taObservations'];
	public $timestamps = false;
}
