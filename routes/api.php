<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Créer un lien qui permettra au client(JS,Spring Boot,ReactJS....) d'avoir accès à cette fonctionnalité


//Récuperer la liste des post
Route::get('posts', [PostController::class ,'index']);




//inscrire  un nouvel utilisateur
Route::post('register', [UserController::class ,'register']);

//s'authentifier après inscription
Route::post('login', [UserController::class ,'login']);


//Retourner l'utilisateur actuellement connecté
//il faut s'authentifier avant de créer,modifier,suprimer un post
Route::middleware('auth:sanctum')->group(function(){

    // ajouter un post
    Route::post('posts/create', [PostController::class,'store']);

    // editer un post (on lui passe directement le post et non l'id .)
    Route::put('posts/edit/{post}', [PostController::class,'update']);

    // supprimer un post
    Route::delete('posts/delete/{post}', [PostController::class,'delete']);

    //retourne les informations du user connecté
    Route::get('/user', function(Request $request){
        return $request->user();
    });

});
