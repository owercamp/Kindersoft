<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseConsolidated extends Model
{
    protected $table = "coursesconsolidated";
	protected $primaryKey = "ccId";
    protected $fillable = ['ccGrade_id','ccCourse_id','ccCollaborator_id','ccDateInitial','ccDateFinal','ccStatus'];
	public $timestamps = false;
}
