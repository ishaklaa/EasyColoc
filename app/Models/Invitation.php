<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    /** @use HasFactory<\Database\Factories\InvitationFactory> */
    use HasFactory;
    protected $fillable = [
        'email',
        'token',
        'statut',
        'colocation_id',
    ];
    public function adhesion(){
        return $this->belongsTo(Colocation::class);
    }
}
