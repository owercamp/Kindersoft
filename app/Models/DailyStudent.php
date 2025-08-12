<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyStudent extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daily_students';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'id_student' => 'integer',
        'id_daily' => 'integer'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function student()
    {
        return $this->hasOne(Student::class,'id','id_student');
    }

    public function note()
    {
        return $this->hasMany(InfoDaily::class, 'id_id', 'id_daily');
    }
}
