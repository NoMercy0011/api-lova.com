<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                'nom'=> $request->nom,
                'pseudo'=> $request->pseudo,
                'role' => $request->role,
                'password'=> hash::make($request->password),
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

        $user = User::where('pseudo', $request->pseudo)-> first();

        if(Hash::check($request ->password, $user->password )){
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

    public function update(Request $request, /*User $user*/){

        $validator = Validator::make($request->all(), [
            'id_user'=> 'required|string',
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
        $user = User::find($request->id_user);

        if($validator->passes()){
            $user->update([
                'nom'=> $request->nom,
                'prenom'=> $request->prenom,
                'email'=> $request->email,
                'sexe'=> $request->sexe,
                'date_naissance'=> $request->date_naissance,
                'lieu_naissance'=> $request->lieu_naissance,
                'telephone'=> $request->telephone,
                'photo'=> $request->photo,
            ]);

            return response()->json([
                'message' => "Mise à jour du profile avec succès",
                'status' => 201,
            ],201);
        }
    }
}
