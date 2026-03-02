<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Depense;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepenseController extends Controller
{
  public function create($id)
  {
    $colocation = Colocation::find($id);
    $categories = $colocation->categories()->get();
    $members = $colocation->users()->get();
    return view('CreateDepense', compact('categories', 'members','colocation'));
  }
  public function store(Request $request, $id)
  {
    $colocation = Colocation::find($id);
    $depense= Depense::create([
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
  // public function getDepense($id)
  // {
  //   $colocation = Colocation::find($id);

  //   $depensesNonPayees = Depense::where('colocation_id', $id)
  //     ->whereHas('paiements', function ($q) {
  //       $q->where('paye', false);
  //     })
  //     ->get();
  //   $depensesPayees = Depense::where('colocation_id', $id)
  //     ->whereHas('paiements', function ($q) {
  //       $q->where('paye', true);
  //     })
  //     ->get();
  //   return view('OwnerColocation', compact('colocation', 'depensesNonPayees', 'depensesPayees'));
  // }
  public function markPayed($id){
    $depense = Depense::find($id);
    $paiement = $depense->paiements()->first();
    $paiement->paye = true;
    $paiement->save();
    $colocation = $depense->colocation()->first();
    return redirect()->route('colocations.show', $colocation->id);

  }
  
}
