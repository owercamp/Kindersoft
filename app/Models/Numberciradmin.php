<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Numberciradmin extends Model
{
    protected $table = "numbercircularadmin";
	protected $primaryKey = "ncaId";
    protected $fillable = ['ncaCode','ncaDate','ncaTo','ncaMessage','ncaFrom_id'];
	public $timestamps = false;
}
