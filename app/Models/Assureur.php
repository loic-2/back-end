<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assureur extends Model
{
    use HasFactory;

    protected $primaryKey='id_assureur';
    protected $fillable=['id_personne'];
}
