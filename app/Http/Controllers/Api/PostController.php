<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditPostRequest;
use App\Http\Requests\CreatePostRequest;

use function Pest\Laravel\post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // url qui permet d'aller de page en page "http://localhost:8000/api/posts?page=3"
        // url qui permet de faire une recherche "http://localhost:8000/api/posts?search=igna"
        try {
            //la pagination
            $query = Post::query(); //Recupere la liste des posts
            $perPage = 3;  // combien nous voulons retourner par page
            $page = $request->input('page', 1); // Recupere la page actuelle de l'utilisateur (par defaut c'est la page 1)
            $search = $request->input('search'); // pour recupérer ce que le user à entrer pour recherche

            //condition pour etre sur que le user à taper quelque chose dans la barre de recherche
            if ($search) {
                $query->whereRaw("titre LIKE '%" . $search . "%'");
            }

            //compte le nombre de resultats trouvé
            $total = $query->count();

            //la pagination elle meme
            $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();


            return response()->json([
                'status_code' => 200,
                'status_message' => 'Liste des posts',
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'items' => $result
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function store(CreatePostRequest $request)
    {

        //le try catch pour les erreur serveur. Cool pour le developpement informatique

        try {
            //Dans le try c'est mon code
            $post = new Post();

            $post->titre = $request->titre;
            $post->description = $request->description;
            //recupérer 'id' du user qui est connecté (la relation 'user' dans 'post')
            $post->user_id= auth()->user()->id;
            $post->save();

            // Reponse envoyé quand le posts est bien créer
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le post à été ajouté avec succès',
                'data' => $post
            ]);
            //Le catch quand il y'a un probleme de serveur 
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(EditPostRequest $request, Post $post)
    {

        //  dd($id);
        // on a le post il s'est que le pos.t existe dejà il va juste ecraser l'ancienne valeur par la nouvelle
        try {

            $post->titre = $request->titre;
            $post->description = $request->description;

                //Si l'id du 'user' 'post' celui qui a créer le post est egal a celui  connecté , il peur modifier sinon...
            if($post->user_id == auth()->user()->id){

                $post->save();

            }else{
                return response()->json([
                    'status_code' => 500,
                    'status_message' => 'Vous ne pouvez pas modifier ce post, vous n\'êtes pas l\'auteur',
                ]);
            }

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le post à été modifié avec succès',
                'data' => $post
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function delete(Post $post)
    {

        //  dd($id);
        try {

             //Si l'id du 'user' 'post' celui qui a créer le post est egal a celui  connecté , il peur modifier sinon...
             if($post->user_id == auth()->user()->id){

                $post->delete();

            }else{
                return response()->json([
                    'status_code' => 500,
                    'status_message' => 'Vous ne pouvez pas supprimer ce post, vous n\'êtes pas l\'auteur',
                ]);
            }

            

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le post à été supprimé avec succès',
                'data' => $post
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
