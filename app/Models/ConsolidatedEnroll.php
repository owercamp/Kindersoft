<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsolidatedEnroll extends Model
{
	protected $table = "consolidatedenrollments";
	protected $primaryKey = "conenId";
    protected $fillable = ['conenStudent_id','conenStatus','conenRequirements'];
	public $timestamps = false;
}
