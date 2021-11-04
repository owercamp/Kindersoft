<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autorization extends Model
{
    protected $table = "autorizations";
	protected $primaryKey = "auId";
    protected $fillable = ['auCourse_id','auStudent_id','auAttendant_id','auDate','auDescription','auAutorized'];
	public $timestamps = false;
}
