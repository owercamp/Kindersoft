<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedingControl extends Model
{
    protected $table = "feedingcontrols";
	protected $primaryKey = "fcId";
    protected $fillable = ['fcDate','fcLegalization_id','fcNews'];
	public $timestamps = false;
}
