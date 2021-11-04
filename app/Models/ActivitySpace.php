<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivitySpace extends Model
{
    protected $table = "activityspaces";
	protected $primaryKey = "asId";
    protected $fillable = ['asNumber','asSpace','asDescription'];
	public $timestamps = false;
}
