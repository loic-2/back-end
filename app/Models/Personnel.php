<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    protected $primaryKey='id_personnel';
    protected $fillable=['id_personne','id_assureur','matricule','prenom'];
}
