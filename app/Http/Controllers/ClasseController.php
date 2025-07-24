<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClasseController extends Controller
{
    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'classe'=> 'required|string',
            'niveau_id' => 'required|int',
            'responsable_id' => 'required|int',
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

            $dateCreated = Classe::create([
                'classe'=> $request->classe ?? null,
                'niveau_id'=> $request->niveau_id ?? null,
                'responsable_id' => $request->responsable_id ?? null,
                'annee_scolaire_id'=> $request->annee_scolaire_id ?? null,
            ]);
        return response()->json([
            'message' => 'création réussi',
            'data' => $dateCreated
        ], 201);
    }
    } 

    public function get(){
        $classes = Classe::with([
            'niveau',
            'responsable',
            'anneeScolaire'
        ])->get()->map(
            function($item) {
                return [
                    'id_classe' => $item->id_classe ?? null,
                    'classe' => $item->classe ?? null,
                    'niveau' => [
                        'id_niveau' =>  $item->niveau->id_niveau ?? null,
                        'niveau' =>  $item->niveau->niveau ?? null
                    ],
                    'responsable' => [
                        'id_user'  =>  $item->responsable->id_user ?? null,
                        'nom'  =>  $item->responsable->nom ?? null,
                        'prenom'  =>  $item->responsable->prenom ?? null,
                    ],
                    'annee_scolaire_id' => [
                        'id_annee_scolaire' => $item->anneeScolaire->id_annee_scolaire ?? null,
                        'annee_scolaire' => $item->anneeScolaire->annee_scolaire ?? null,
                    ]
                ];
            }
        );
        return response()->json([
            'classes' =>  $classes,
        ]);
    }
}
