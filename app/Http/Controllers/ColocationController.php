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
        // $colocations = Colocation::with('owner')->where('statut', 'active')->get();
        $colocations = Auth::user()->colocations()->with('owner')->get();
        return view('CollocationDashboard', compact('colocations'));
    }
    public function create()
    {
        return view('CreateCollocation');
    }
    public function join()
    {
        return view('joinColocation');
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
        $owner_id = $colocation->owner()->first()->id;
        $user = Auth::user();
        if ($user->id == $owner_id) {
            $members = $colocation->users()->get();
            $categories = $colocation->categories()->get();
            $invitation_token = Str::random(8);
            Invitation::create([
                'colocation_id' => $id,
                'statut' => 'en attente',
                'token' => $invitation_token,
            ]);
            // $invitation_token = Invitation::where('colocation_id', $id)->latest()->first()->token;
            return view('OwnerColocation', compact('members', 'categories', 'colocation', 'invitation_token'));
        } else {
            return view('MemberColocation');
        }


    }
    public function tokenGenerate($id)
    {
        $colocation = Colocation::find($id);
        $invitation_token = Str::random(8);
        Invitation::create([
            'colocation_id' => $id,
            'statut' => 'en attente',
            'token' => $invitation_token,
        ]);
        return redirect()->route('colocations.show', $colocation);
    }
    public function tokenCheck(Request $request)
    {
        $user = Auth::user();
        $token = $request->token;
        $colocation = Colocation::where('statut', 'active')
            ->whereHas('invitations', function ($query) use ($token) {
                $query->where('token', $token);
            })
            ->first();
        if ($colocation) {
            $isUserIn = Colocation::where('statut', 'active')
                ->whereHas('users', function ($q) use ($user) {
                    $q->where('users.id', $user->id); 
                })
                ->exists();
            if ($isUserIn) {
                return back()->with('error', 'vous étes déja dans une colocation active');
            } else {
                $user->colocations()->attach($colocation->id, [
                    'role' => 'member',
                ]);
                return redirect()->route('colocations.show', $colocation->id);
            }
        }
        return back()->with('error', 'Token invalide ou colocation inactive.');
    }


}