<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventcreation extends Model
{
    protected $table = "eventCreations";
	protected $primaryKey = "crId";
    protected $fillable = ['crName','crDescription'];
	public $timestamps = false;
}
