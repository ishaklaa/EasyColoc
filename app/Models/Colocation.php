<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    /** @use HasFactory<\Database\Factories\ColocationFactory> */
    use HasFactory;
    protected $fillable = [
        'statut',
        'titre',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'adhesions')->withPivot('role', 'laisse_a')->withTimestamps();
    }

    public function owner()
    {
        return $this->users()->wherePivot('role', 'owner');
    }
    public function members()
    {
        return $this->users()->wherePivot('role', 'member');
    }
    public function allUsers()
    {
        return $this->users();

    }
    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }
    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
