<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coststructure extends Model
{
    protected $table = "costStructure";
	protected $primaryKey = "csId";
    protected $fillable = ['csDescription'];
	public $timestamps = false;
}