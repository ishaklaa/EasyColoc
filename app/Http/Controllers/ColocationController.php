<?php

namespace App\Http\Controllers;

use App\Models\Adhesion;
use App\Models\Colocation;

use App\Models\Depense;
use App\Models\Invitation;
use App\Models\Paiement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;
use PhpParser\Node\Scalar\MagicConst\Function_;

class ColocationController extends Controller
{
    public function index()
    {
        // $colocations = Colocation::with('owner')->where('statut', 'active')->get();
        // $colocations = Auth::user()->colocations()->with('owner')->get();
        $user = Auth::user();
        $currentColocation = Colocation::where('statut', 'active')
            ->whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id)->whereNull('adhesions.laisse_a');
            })->first();
        $pastColocations = Colocation::whereHas('users', function ($q) use ($user) {
            $q->where('users.id', $user->id)
                ->whereNotNull('adhesions.laisse_a');
        })->get();
        return view('CollocationDashboard', compact('currentColocation', 'pastColocations'));
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
        $isUserIn = Colocation::where('statut', 'active')
            ->whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->exists();
        if ($isUserIn) {
            return back()->with('error', 'vous étes déja dans une colocation active');
        } else {
            $colocation = Colocation::create([
                'titre' => $request->titre,
                'statut' => 'active',
            ]);
            $user->colocations()->attach($colocation->id, [
                'role' => 'owner',
            ]);
            return redirect()->route('admin.colocations.index');
        }

    }
    public function show($id)
    {
        $colocation = Colocation::find($id);
        $owner_id = $colocation->owner()->first()->id;
        $user = Auth::user();
        if ($user->id == $owner_id) {
            $members = User::whereHas('colocations', function ($q) use ($colocation) {
                $q->where('colocations.id', $colocation->id)
                    ->whereNull('adhesions.laisse_a');
            })->get();
            $categories = $colocation->categories()->get();
            $invitation_token = Str::random(8);
            Invitation::create([
                'colocation_id' => $id,
                'statut' => 'en attente',
                'token' => $invitation_token,
            ]);
            $colocation = Colocation::find($id);
            $depenses = Depense::where('colocation_id', $id)
                ->whereHas('paiements', function ($q) {
                    $q->where('paye', false);
                })
                ->get();
            $usersCount = User::whereHas('colocations', function ($q) {
                $q->whereNull('adhesions.laisse_a');
            })->count();



            $dettes = [];
            $part = 0;
            foreach ($depenses as $depense) {
                $part += $depense->montant / $usersCount;
                $payeur = $colocation->users()->where('users.id', $depense->payeur_id)->first();
                $payeur->solde = $depense->montant - $part;
                $payeur->save();
                $debiteurs = User::where('users.id', '!=', $depense->payeur_id)->whereHas('colocations', function ($q) {
                    $q->whereNull('adhesions.laisse_a');
                })->get();
                foreach ($debiteurs as $debiteur) {
                    $debiteur->solde = -$part;
                    $debiteur->save();
                    $dettes[] = (object) [
                        'montant' => $part,
                        'creancier' => $payeur,
                        'debiteur' => $debiteur
                    ];
                }
            }

            $depensesNonPayees = Depense::where('colocation_id', $id)
                ->whereHas('paiements', function ($q) {
                    $q->where('paye', false);
                })
                ->get();
            $depensesPayees = Depense::where('colocation_id', $id)
                ->whereHas('paiements', function ($q) {
                    $q->where('paye', true);
                })
                ->get();
            return view('OwnerColocation', compact('members', 'categories', 'colocation', 'invitation_token', 'dettes', 'depensesNonPayees', 'depensesPayees'));
        } else {
            $members = User::whereHas('colocations', function ($q) use ($colocation) {
                $q->where('colocations.id', $colocation->id)
                    ->whereNull('adhesions.laisse_a');
            })->get();

            $depenses = Depense::where('colocation_id', $id)
                ->whereHas('paiements', function ($q) {
                    $q->where('paye', false);
                })
                ->get();
            $usersCount = User::whereHas('colocations', function ($q) {
                $q->whereNull('adhesions.laisse_a');
            })->count();


            $dettes = [];
            $part = 0;
            foreach ($depenses as $depense) {
                $part += $depense->montant / $usersCount;
                $payeur = $colocation->users()->where('users.id', $depense->payeur_id)->first();
                $payeur->solde = $depense->montant - $part;
                $payeur->save();
                $debiteurs = User::where('users.id', '!=', $depense->payeur_id)->whereHas('colocations', function ($q) {
                    $q->whereNull('adhesions.laisse_a');
                })->get();
                foreach ($debiteurs as $debiteur) {
                    $debiteur->solde = $part;
                    $debiteur->save();
                    $dettes[] = (object) [
                        'montant' => $part,
                        'creancier' => $payeur,
                        'debiteur' => $debiteur
                    ];
                }
            }

            $depensesNonPayees = Depense::where('colocation_id', $id)
                ->whereHas('paiements', function ($q) {
                    $q->where('paye', false);
                })
                ->get();
            $depensesPayees = Depense::where('colocation_id', $id)
                ->whereHas('paiements', function ($q) {
                    $q->where('paye', true);
                })
                ->get();
            return view('MemberColocation', compact('members', 'colocation', 'dettes', 'depensesNonPayees', 'depensesPayees'));
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
    public function removeMember($col_id, $user_id)
    {
        $adhesion = Adhesion::where('user_id', $user_id)
            ->where('colocation_id', $col_id)
            ->firstOrFail();
        $adhesion->laisse_a = now();
        $adhesion->save();
        $colocation = Colocation::find($col_id);
        $members_count = User::whereHas('colocations', function ($q) use ($colocation) {
            $q->where('colocations.id', $colocation->id)
                ->whereNull('adhesions.laisse_a');
        })->count();
        $user = User::find($user_id);
        $user_solde = $user->solde;
        $depense = Depense::where('colocation_id', $col_id)->where('payeur_id', $user_id)->first();
        $paiements = $user->paiements()->get();

        if ($user_solde < 0 && $members_count > 0) {
            $user->reputation -= 1;
            $user->solde = 0;
            $user->save();

            return redirect()->route('colocations.show', $col_id);
        } else if ($user_solde >= 0) {
            $user->solde = 0;
            $user->reputation += 1;
            $user->save();
            foreach ($paiements as $paiement) {
                $paiement->paye = true;
                $paiement->save();
            }
            return redirect()->route('colocations.show', $col_id);

        }



    }
    public function leaveMember($id)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $user_solde = $user->solde;
        $adhesion = Adhesion::where('user_id', $user_id)
            ->where('colocation_id', $id)
            ->firstOrFail();
        $adhesion->laisse_a = now();
        $adhesion->save();
        $paiements = $user->paiements()->get();

        if ($user_solde < 0) {
            $user->reputation -= 1;
            $user->solde = 0;
            $user->save();

            return redirect()->route('admin.colocations.index');
        } else if ($user_solde >= 0) {
            $user->solde = 0;
            $user->reputation += 1;
            $user->save();
            foreach ($paiements as $paiement) {
                $paiement->paye = true;
                $paiement->save();
            }
            return redirect()->route('admin.colocations.index');

        }
    }


}