<?php

namespace App\Http\Controllers;

use App\Models\EnseignantActive;
use App\Models\User;
use DateTime;
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
             $user =  User::create([
                'nom'=> $request->nom ?? null,
                'prenom'=> $request->prenom ?? null,
                'pseudo'=> $request->pseudo ?? null,
                'photo'=> $request->photo ?? null,
                'date_naissance'=> $request->date_naissance ?? null,
                'lieu_naissance'=> $request->lieu_naissance ?? null,
                'email'=> $request->email ?? null,
                'sexe'=> $request->sexe ?? null,
                'telephone'=> $request->telephone ?? null,
                'role' => $request->role ?? null,
                'password'=> hash::make($request->password ?? null),
            ]);

            $enseignant =  EnseignantActive::create([
                'user_id' => $user->id_user ?? null,
                'section_id'=> $request->section ?? null,
                'salaire'=> $request->salaire ?? null,
                'date_entree' => $request->date_entree ?? new DateTime( now()),
            ]);

            return response()->json([
                'message' => "Inscription réussie",
                'user' => $user,
                'enseignant' => $enseignant,
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
