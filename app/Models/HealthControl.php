<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthControl extends Model
{
    protected $table = "healthcontrols";
	protected $primaryKey = "hcId";
    protected $fillable = ['hcDate','hcLegalization_id','hcNews'];
	public $timestamps = false;
}
