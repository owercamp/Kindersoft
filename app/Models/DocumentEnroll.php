<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentEnroll extends Model
{
    protected $table = "documentsEnrollment";
    protected $primaryKey = 'deId';
    protected $fillable = [ 'deConcept','deRequired','deStatus','dePosition' ];
    public $timestamps = false;
}
