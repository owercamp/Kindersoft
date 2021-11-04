<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalMemo extends Model
{
    protected $table = "internal_memo_file";

    protected $primaryKey = "imf_id";

    protected $guarded = [];
}
