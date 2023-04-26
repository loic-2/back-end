<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;
    protected $primaryKey='id_tache';
    protected $fillable=['id_personnel','id_activite','nom','debut','fin'];
}
