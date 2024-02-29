<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogUserRequest;
use App\Http\Requests\RegisterUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function register(RegisterUser $request)
    {

        try {

            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            //pour hasher le mot de passe.Le rounds pour plus securisé le password (voir documentation laravel)
            $user->password = Hash::make($request->password, [
                'rounds' => 12
            ]);

            $user->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le user a été ajouté avec succès',
                'data' => $user
            ]);
            //Le catch quand il y'a un probleme de serveur 
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function login(LogUserRequest $request){

        //recupere les données de la personne qui essai de ce connecté et faire une coparaison avec les données de la BD
        //génère un token qui va permettre d'avoir accès aux autres fonctionnalités
    
        if (auth()->attempt($request->only(['email','password']))) {
            # code...
            $user= auth()->user();

            $token= $user->createToken('MA_CLE_SECRETE_VISIBLE_UNIQUEMENT_AU_BACKEND')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Valider',
                'data' => $user,
                'token'=> $token
            ]);
        }else{
            //si les informations ne correspond a aucun utilisateur
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Identifiant incorrect',
            ]);
        }


    }
}
