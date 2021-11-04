<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Legalization extends Model
{
    protected $table = "legalizations";
	protected $primaryKey = "legId";
    protected $fillable = ['legStudent_id','legAttendantfather_id','legAttendantmother_id','legGrade_id','legJourney_id','legDateInitial','legDateFinal','legDateCreate','legStatus','legArgument'];
	public $timestamps = false;
}
