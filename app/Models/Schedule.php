<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    protected $primaryKey = 'sch_id';

    protected $fillable = [
        'sch_body'
    ];

    public $timestamps = false;
}
