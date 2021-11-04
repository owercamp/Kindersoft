<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annual extends Model
{
    protected $table = "annual";
	protected $primaryKey = "aId";
    protected $fillable = ['aYear','aCostDescription_id','aValue','aDetailsMount','aDate'];
	public $timestamps = false;
}
