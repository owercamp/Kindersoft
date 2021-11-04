<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionHealth extends Model
{
    protected $table = "professionalHealth";
	protected $primaryKey = "phId";
    protected $fillable = ['phName'];
	public $timestamps = false;
}
