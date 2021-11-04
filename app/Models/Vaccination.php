<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    protected $table = "vaccinations";
	protected $primaryKey = "vaId";
    protected $fillable = ['vaName'];
	public $timestamps = false;
}
