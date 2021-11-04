<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obserbull extends Model
{
    protected $table = "observations_bulletin";
	protected $primaryKey = "obuId";
    protected $fillable = ['obuBulletin_id','obuObservation_id'];
	public $timestamps = false;
}
