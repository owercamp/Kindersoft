<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Costdescription extends Model
{
    protected $table = "costDescription";
	protected $primaryKey = "cdId";
    protected $fillable = ['cdCoststructure_id','cdDescription'];
	public $timestamps = false;
}