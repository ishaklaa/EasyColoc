<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    /** @use HasFactory<\Database\Factories\CategorieFactory> */
    use HasFactory;
    protected $fillable = [
        'titre',
        'colocation_id',
    ];
    public function depense(){
        return $this->belongsTo(Categorie::class);
    }
    public function colocation(){
        return $this->belongsTo(Colocation::class);
    }
}
