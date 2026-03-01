<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    public function create($id){
      $colocation= Colocation::find($id);
      $categories = $colocation->categories()->get();
      $members = $colocation->users()->get();
      return view('CreateDepense',compact('categories','members'));
    }
}
