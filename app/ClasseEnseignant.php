<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClasseEnseignant extends Model
{
    protected $fillable = [
        'Classe_code', 'Enseignant_id'
    ];

    protected $hidden = [
        'created_at', 'update_at'
    ];

    public $timestamps=false;

    protected $table="ClassesEnseignants";
}
