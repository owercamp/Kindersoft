<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    protected $table = "observations";
	protected $primaryKey = "obsId";
    protected $fillable = ['obsNumber','obsDescription','obsIntelligence_id'];
	public $timestamps = false;
}
