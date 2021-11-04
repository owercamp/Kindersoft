<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listcourse extends Model
{
    protected $table = "listcourses";
	protected $primaryKey = "listId";
    protected $fillable = ['listGrade_id','listCourse_id','listStudent_id'];
	public $timestamps = false;
}
