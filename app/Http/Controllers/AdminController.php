<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
      
        $users = User::where('role', 'user')->get();
        $usersCount = $users->count();
        $bannedUsersCount = $users->where('status', 'bloque')->count();
        $colocationsCount = Colocation::count();

        return view('Admindashboard', compact('users', 'usersCount', 'bannedUsersCount', 'colocationsCount'));
        
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->statut = $request->status;
        $user->save();
        return redirect()->route("login.dashboard");
    }
}
