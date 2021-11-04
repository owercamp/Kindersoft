<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    protected $table = "assistances";
	protected $primaryKey = "assId";
    protected $fillable = ['assCourse_id','assDate','assPresents','assAbsents','assStatus'];
	public $timestamps = false;
}
