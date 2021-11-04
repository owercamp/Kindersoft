<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityClass extends Model
{
    protected $table = "activityclass";
	protected $primaryKey = "acId";
    protected $fillable = ['acNumber','acClass','acDescription'];
	public $timestamps = false;
}
