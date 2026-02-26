<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard(){
        $users = User::all();
        return view("AdminDashboard",compact("users"));
    }
    public function update(Request $request, $id){
        $user = User::find($id);
        $user->statut = $request->status;
        $user->save();
        return redirect()->route("login.dashboard");
}
}
