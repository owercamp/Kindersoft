<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Baseactivity extends Model
{
    protected $table = "baseactivitys";
	protected $primaryKey = "baId";
    protected $fillable = ['baDescription','baIntelligence_id'];
	public $timestamps = false;
}
