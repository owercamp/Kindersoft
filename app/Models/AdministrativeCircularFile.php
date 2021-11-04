<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrativeCircularFile extends Model
{
    protected $table = "administrative_circular_file";

    protected $primaryKey = "acf_id";

    protected $guarded = [];

    public function body()
    {
        return $this->belongsTo(Body::class, "bcId");
    }

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class, "id");
    }
}
