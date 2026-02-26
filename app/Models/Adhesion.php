<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Adhesion extends Model
{
    /** @use HasFactory<\Database\Factories\AdhesionFactory> */
    use HasFactory;
    protected $fillable = ['role', 'user_id', 'colocation_id',];
    public function user(): BelongsTo 
    {

    }
}
