<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicCircularFile extends Model
{
    protected $table = "academic_circular_files";

    protected $primaryKey = "acf_id";

    protected $guarded = [];

    public function body()
    {
        return $this->belongsTo(Body::class, 'bcId');
    }

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class, 'id');
    }
}
