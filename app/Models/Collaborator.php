<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    protected $table = "collaborators";
    protected $fillable = [
        'id',
        'typedocument_id',
        'numberdocument',
        'firstname',
        'threename',
        'fourname',
        'photo',
        'address', //Nullable
        'cityhome_id', //Nullable
        'locationhome_id', //Nullable
        'dictricthome_id', //Nullable
        'phoneone', //Nullable
        'phonetwo', //Nullable
        'whatsapp', //Nullable
        'emailone', //Nullable
        'emailtwo', //Nullable
        'bloodtype_id', //Nullable
        'gender',
        'profession_id', //Nullable
        'position',
        'firm'
    ];

    public $timestamps = false;
}
