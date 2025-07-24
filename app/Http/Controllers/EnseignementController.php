<?php

namespace App\Http\Controllers;

use App\Models\Enseignement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\String_;

class EnseignementController extends Controller
{
    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'classe_id'=> 'required|int',
            'matiere_id' => 'required|int',
            'enseignant_id' => 'required|int',
            'coefficient'=> 'required|int',
            'horaire'=> 'required|json',
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
        $horaire = json_decode($request->horaire ?? null) ;
        //$horaire->json();
        if($validator->passes()){

            $dateCreated = Enseignement::create([
                'classe_id'=> $request->classe_id ?? null,
                'matiere_id'=> $request->matiere_id ?? null,
                'enseignant_id' => $request->enseignant_id ?? null,
                'coefficient'=> $request->coeficient ?? null,
                'horaire'=> $horaire,
                'annee_scolaire_id'=> $request->annee_scolaire_id ?? null,
            ]);
        return response()->json([
            'message' => 'création réussi',
            'data' => $dateCreated
        ], 201);
    }
    } 
    public function get(Request $request) {
        $enseignement = Enseignement::with([
            'classe',
            'matiere',
            'enseignant',
            'anneeScolaire'
        ])->get()->map(function ($item){
            return[
                'id_enseignement' => $item->id_enseignement ?? null,
                'classe' => [
                    'id_classe' => $item->classe->id_classe ?? null,
                    'classe' => $item->classe->classe ?? null,
                ],
                'matiere' => [
                    'id_matiere' => $item->matiere->id_matiere ?? null,
                    'matiere' => $item->matiere->matiere ?? null,
                ],
                'enseignant' => [
                    'id_user' => $item->enseignant->id_user ?? null,
                    'nom' => $item->enseignant->nom ?? null,
                    'prenom' => $item->enseignant->prenom ?? null,
                    'pseudo' => $item->enseignant->pseudo ?? null,
                ],
            ];
        });
        return response()->json([
            'enseignements' => $enseignement,
        ]);
    }
}
