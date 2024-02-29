<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Personne;
use Illuminate\Http\Request;

class PersonneController extends Controller
{
    public function create(){

        return view('personne');
    }

    public function store(Request $request){

        $request->validate([

            'titre'=>['required','max:255','min:5'],
            'description'=>['required']
        ]);

        Personne::create([
            'titre'=>$request->titre,
            'description'=>$request->description
        ]);

        dd('Personne créé');

        return view('form');
    }
}
