<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsolideAchievement extends Model
{
    protected $table = "consolide_achievements";

    protected $fillable = ['id','achievement_id','period_id','course_id'];

    public $timestamps = false;
}
