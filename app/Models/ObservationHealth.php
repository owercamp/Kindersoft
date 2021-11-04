<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObservationHealth extends Model
{
    protected $table = "observationsHealth";
	protected $primaryKey = "ohId";
    protected $fillable = ['ohObservation'];
	public $timestamps = false;
}
