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
        'colocation_id',
        'paye',
        'categorie',
        
    ];
    public function paiements(){
        return $this->hasMany(Paiement::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function colocation(){
        return $this->belongsTo(Colocation::class);
    }
    public function categories(){
        return $this->hasMany(Categorie::class);
    }
}
