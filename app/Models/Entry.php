<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
  protected $table = "voucherentrys";
  protected $primaryKey = "venId";
  protected $fillable = ['venCode', 'venDate', 'venStudent_id', 'venFacturation_id', 'venPaid', 'venDescription', 'venObs'];
  public $timestamps = false;
}
