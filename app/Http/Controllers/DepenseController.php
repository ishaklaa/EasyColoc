<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Depense;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepenseController extends Controller
{
  public function create($id)
  {
    $colocation = Colocation::find($id);
    $categories = $colocation->categories()->get();
    $members = User::whereHas('colocations', function ($q) use ($colocation) {
      $q->where('colocations.id', $colocation->id)
        ->whereNull('adhesions.laisse_a');
    })->get();
    return view('CreateDepense', compact('categories', 'members', 'colocation'));
  }
  public function store(Request $request, $id)
  {
    $colocation = Colocation::find($id);
    $depense = Depense::create([
      'titre' => $request->titre,
      'payeur_id' => $request->payeur_id,
      'montant' => $request->montant,
      'createur_id' => Auth::user()->id,
      'colocation_id' => $id,
      'categorie' => $request->categorie,
    ]);

    Paiement::create([
      'user_id' => $request->payeur_id,
      'depense_id' => $depense->id,
      'montant' => $depense->montant,
      'paye' => false,
    ]);
    return redirect()->route('colocations.show', $id);
  }
  
  public function markPayed($id)
  {
    $depense = Depense::find($id);
    $paiement = $depense->paiements()->first();
    $paiement->paye = true;
    $paiement->save();
    $colocation = $depense->colocation()->first();
    $coloc_users = $colocation->users()->get();
    foreach ($coloc_users as $user) {
      $user->solde = 0;
      $user->save();
    }
    return redirect()->route('colocations.show', $colocation->id);

  }

}
