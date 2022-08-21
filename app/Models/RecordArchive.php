<?php

namespace App\Models;

use App\Models\Bloodtype;
use Illuminate\Database\Eloquent\Model;

class RecordArchive extends Model
{
    protected $table = 'record_archives';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = true;

    public function student()
    {
        return $this->belongsTo(Bloodtype::class, 'tiposangre','id');
    }

    public function rhacu1()
    {
        return $this->belongsTo(Bloodtype::class, 'rhacu1', 'id');
    }

    public function rhacu2()
    {
        return $this->belongsTo(Bloodtype::class, 'rhacu2', 'id');
    }

    public function docacu1()
    {
        return $this->belongsTo(Document::class, 'docacu1','id');
    }

    public function docacu2()
    {
        return $this->belongsTo(Document::class, 'docacu2','id');
    }

}
