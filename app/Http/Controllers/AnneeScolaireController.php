<?php

namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnneeScolaireController extends Controller
{
    public function createAnneeScolaire(Request $request){
        $validator = Validator::make($request->all(), [
            'annee_scolaire'=> 'required|string|unique:tenant.annee_scolaire',
            'annee_debut' => 'required|date',
            'annee_fin' => 'required|date',
            'status'=> 'required|string',
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

            $dateCreated = AnneeScolaire::create([
                'annee_scolaire'=> $request->annee_scolaire ?? null,
                'annee_debut'=> $request->annee_debut ?? null,
                'annee_fin' => $request->annee_fin ?? null,
                'status'=> $request->status ?? null,

            ]);
        return response()->json([
            'message' => 'création réussi',
            'data' => $dateCreated
        ], 201);
    }
    } 

    public function createPeriode(Request $request){

        $validator = Validator::make($request->all(), [
            'nom'=> 'required|string',
            'ordre' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin'=> 'required|date',
            'annee_scolaire_id'=> 'required|int',
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

            $dateCreated = Periode::create([
                'nom'=> $request->nom ?? null,
                'ordre'=> $request->ordre ?? null,
                'date_debut' => $request->date_debut ?? null,
                'date_fin'=> $request->date_fin ?? null,
                'annee_scolaire_id'=> $request->annee_scolaire_id ?? null,
            ]);
        return response()->json([
            'message' => 'création réussi',
            'data' => $dateCreated
        ], 201);
    }
    } 
}
