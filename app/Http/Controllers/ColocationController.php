<?php

namespace App\Http\Controllers;

use App\Models\Adhesion;
use App\Models\Colocation;

use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function index()
    {
        $colocations = Colocation::with('owner')->where('statut', 'active')->get();
        // $adhesions = Adhesion::all();
        return view('CollocationDashboard', compact('colocations'));
    }
    public function create()
    {
        return view('CreateCollocation');
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $colocation = Colocation::create([
            'titre' => $request->titre,
            'statut' => 'active',
        ]);
        $user->colocations()->attach($colocation->id, [
            'role' => 'owner',
        ]);
        return redirect()->route('admin.colocations.index');
    }
    public function show($id)
    {
        $colocation = Colocation::find($id);
        $owner_id = $colocation->owner()->id;
        $user = Auth::user();
        if (!$user->colocations()->where('statut', 'active')->exists()) {
            if ($user->id == $owner_id) {
                $members = $colocation->members()->get();
                $categories = $colocation->categories()->get();
                $invitation_token = Invitation::where('colocation_id', $id)->latest()->first();
                return view('OwnerColocation', compact('members', 'categories', 'colocation','invitation_token'));
            }
        }
    }
    public function tokenGenerate($id)
    {
        $colocation = Colocation::find($id);
        $invitation = Invitation::create([
            'colocation_id' => $id,
            'statut' => 'en attente',
            'token' => Str::random(8),
        ]);

    }
}