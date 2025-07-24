<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'pseudo'=> 'required|string|unique:tenant.user',
            'role' => 'required|string',
            'password'=> 'required|min:8',
        ]);


        if($validator->fails()){
            $error = $validator->errors();
            return response()->json([
                'message' => "Un erreur s'est produit",
                'errors' => $error,
                'status' => 401,
            ],401);
        }

        if($validator->passes()){
            $user = User::create([
                'nom'=> $request->nom ?? null,
                'pseudo'=> $request->pseudo ?? null,
                'role' => $request->role ?? null,
                'password'=> hash::make($request->password ?? null),
            ]);

            $token = $user->createToken(time())->plainTextToken;
            return response()->json([
                'message' => "Inscription réussie",
                'accusée' => $user,
                'token' => $token,
                'type' => 'Bearer',
                'status' => 201,
            ],201);
        }


    }
    public function authenticate(Request $request)  {
        if(!Auth::attempt($request->only('pseudo', 'password'))){
            return response()-> json([
                'message' => 'Pseudo ou Mot de passe incorrect',
                'status' => 401,
            ],401);
        }

        $user = User::where('pseudo', $request->pseudo ?? null)-> first();

        if(Hash::check($request ->password ?? null, $user->password )){
            return response()->json([
                'token' => $user->createToken(time())->plainTextToken,
                'status' => 201,
                'message' => 'Connexion réussie',
                'user' => $user,
            ],201);
        }
    }



    public function user(Request $request): User {

        return $request->user();
    }

    public function getEnseignant(Request $request){
        $enseignants = User::all()->map( function ($item){
            return [
                'id_enseignant' => $item->id_user ?? null,
                'nom' => $item->nom ?? null,
                'prenom' => $item->prenom ?? null,
                'pseudo' => $item->pseudo ?? null,
                'sexe' => $item->sexe ?? null,
            ];
        });
        return response()->json([
            'enseignant' =>$enseignants
        ], 200);
    }

    public function update(Request $request, User $user){
        $user = $request->user();
        $id_user = $user->id_user ?? null;

        $validator = Validator::make($request->all(), [
            //'id_user'=> 'required|string',
            'nom'=> 'required|string',
            'prenom' => 'required|string',
            'email'=> 'required|string',
            'sexe'=> 'required|string',
            'date_naissance'=> 'required|string',
            'lieu_naissance'=> 'required|string',
        ]);

        if($validator->fails()){
            $error = $validator->errors();
            return response()->json([
                'message' => "Un erreur s'est produit",
                'errors' => $error,
                'status' => 401,
            ],401);
        }
        $userToUpdate = User::find($id_user);
        // if($validator->passes()){
        $userToUpdate->update( $request->all());

        return response()->json([
                'message' => "Mise à jour du profile avec succès",
                'status' => 201,
                'user' => $user
            ],201);

            
            
        // }
    }
}
