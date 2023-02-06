<?php

namespace App\Models;

use App\Models\Body;
use App\Models\Collaborator;
use Illuminate\Database\Eloquent\Model;

class AdministrativeCircularFile extends Model
{
    protected $table = "administrative_circular_file";

    protected $primaryKey = "acf_id";

    protected $guarded = [];

    public function body()
    {
        return $this->belongsTo(Body::class, "acf_cirBody_id", "bcId");
    }

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class, "acf_cirFrom", "id");
    }
}
