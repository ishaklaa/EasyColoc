<?php

namespace App\Http\Controllers;

// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;
use app\Models\User;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    public function roleCheck(){
        
        $user = Auth::user();
            // dd($user);

        if ($user->role == 'admin'){
            return redirect()->route('login.dashboard');
        }
    }
    }

