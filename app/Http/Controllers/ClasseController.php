<?php

namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClasseController extends Controller
{
    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'classe'=> 'required|string|unique:tenant.classe',
            'niveau' => 'required|int',
            'section' => 'required|int',
            'responsable' => 'required|int',
        ]);

        $annee = AnneeScolaire::where('status', '=', 'active' )->get()->first();

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
                'niveau_id'=> $request->niveau ?? null,
                'section_id'=> $request->section ?? null,
                'responsable_id' => $request->responsable ?? null,
                'annee_scolaire_id'=> $annee->id_annee_scolaire ?? null,
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
            'responsable.enseignant',
            'anneeScolaire',
            'section'
        ])->get()->map(function($item) {
                return [
                    //'data' => $item ?? null,
                    'id_classe' => $item->id_classe ?? null,
                    'classe' => $item->classe ?? null,
                    'niveau' => [
                        'id_niveau' =>  $item->niveau->id_niveau ?? null,
                        'niveau' =>  $item->niveau->niveau ?? null
                    ],
                    'responsable' => [
                        'id_user'  =>  $item->responsable->enseignant->id_user ?? null,
                        'nom'  =>  $item->responsable->enseignant->nom ?? null,
                        'prenom'  =>  $item->responsable->enseignant->prenom ?? null,
                        'sexe'  =>  $item->responsable->enseignant->sexe ?? null,
                    ],
                    'section' => [
                        'id_section' => $item->section->id_section ?? null,
                        'section' => $item->section->section ?? null,
                    ],
                    'annee_scolaire' => [
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

    public function update(Request $request) {
        $id = $request->id_classe ?? null;
        $annee = AnneeScolaire::where('status', '=', 'active' )->get()->first();

        $classe = Classe::find( $id );
        //dd($classe);

        $validator = Validator::make($request->all(), [
            'classe'=> 'required|string',
            'niveau_id' => 'required|string',
            'section_id'=> 'required|string',
            'responsable_id'=> 'required|string',
        ]);

        if($validator->fails()){
            $error = $validator->errors();
            return response()->json([
                'message' => "Un erreur s'est produit",
                'errors' => $error,
                'status' => 401,
            ],401);
        }
        //dd($validator->validate() , $classe->only(array_keys($validator->validate()))) ;
        $diff = array_diff_assoc( 
            $validator->validate(), 
            
            $classe->only(array_keys($validator->validate()))
        ) ;

        if(empty($diff)) {
            return response()->json([
                'message' => 'Aucune modification apportée',
            ], 200);
        }

        $classe->update( [
            'classe' => $request->classe ?? null,
            'niveau_id' => $request->niveau_id ?? null,
            'section_id' => $request->section_id ?? null,
            'responsable_id' => $request->responsable_id ?? null,
            'annee_scolaire_id' => $annee->id_annee_scolaire,
        ]);

        
        return response()->json([
            'message' => 'La classe à été mis à jour',
            'classe' => $classe,
        ]);
    }
}
