<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Academicperiod extends Model
{
    protected $table = "academicperiods";
	protected $primaryKey = "apId";
    protected $fillable = ['apNameperiod','apDateInitial','apDateFinal','apCourse_id','apStatus'];
	public $timestamps = false;
}
