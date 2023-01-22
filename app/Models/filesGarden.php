<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class filesGarden extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files_gardens';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'header' => 'string',
      'footer' => 'string',
      'format' => 'string',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
