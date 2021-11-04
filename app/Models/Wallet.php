<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = "wallets";
	protected $primaryKey = "waId";
    protected $fillable = ['waMoney','waStatus','waStudent_id'];
	public $timestamps = false;
}
