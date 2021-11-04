<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
  protected $table = 'presences';

  protected $primaryKey = 'pre_id';

  protected $guarded = [];

  public function student()
  {
    return $this->belongsTo(Student::class, 'pre_student');
  }
  public function course()
  {
    return $this->belongsTo(Course::class, 'pre_course');
  }
}
