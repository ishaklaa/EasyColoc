<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    /** @use HasFactory<\Database\Factories\DepenseFactory> */
    use HasFactory;
    protected $fillable = [
        'titre',
        'montant',
        'createur_id',
        'payeur_id',
        'adhesion_id',
        'colocation_id',
        'paye',
        'depense_id',
    ];
}
