<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    protected $table = "bulletins";
	protected $primaryKey = "buId";
    protected $fillable = ['buStudent_id','buCourse_id','buPeriod_id'];
	public $timestamps = false;
}
