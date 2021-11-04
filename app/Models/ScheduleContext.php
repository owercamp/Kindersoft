<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleContext extends Model
{
    protected $table = 'schedule_contexts';

    protected $primaryKey = 'sch_id';

    protected $fillable = [
        'sch_body'
    ];

    public $timestamps = false;
}
