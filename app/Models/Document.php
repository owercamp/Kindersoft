<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = "documents";

    protected $fillable = [ 'id','type' ];

    public $timestamps = false;
}
