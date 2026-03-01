<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Colocation;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function store(Request $request, $id)
    {
        $colocation = Colocation::find($id);
        Categorie::create([
            'colocation_id' => $id,
            'titre' => $request->categorie,
        ]);
        return redirect()->route('colocations.show',$colocation);
    }
}
