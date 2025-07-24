<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EtudiantController extends Controller
{
    
    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'nom'=> 'required|string',
            'sexe' => 'required|string',
            'matricule' => 'required|string:unique.tenant.inscription',
            'classe_id'=> 'required|int',
            'date_entree'=> 'required|date',
            'staus'=> 'required|string',
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


           try{
                $etudiant = Etudiant::create([
                'nom'=> $request->nom ?? null,
                'prenom'=> $request->prenom ?? null,
                'date_naissance'=> $request->date_naissance ?? null,
                'lieu_naissance' => $request->lieu_naissance ?? null,
                'sexe'=> $request->sexe ?? null,
                'domicile'=> $request->domicile ?? null,
                'nom_pere'=> $request->nom_pere ?? null,
                'nom_mere'=> $request->nom_mere ?? null,
                'telephone_parent'=> $request->telephone_parent ?? null,
                'nom_tuteur'=> $request->nom_mere ?? null,
                'telephone_tuteur'=> $request->telephone_tuteur ?? null,
                'telephone_urgence'=> $request->telephone_urgence ?? null,
            ]);

            $inscription = Etudiant::create([
                'etudiant_id'=> $etudiant->id_etudiant ?? null,
                'matricule' => $request->matricule ?? null,
                'classe_id'=> $request->classe_id ?? null,
                'date_entree'=> $request->date_entree ?? null,
                'annee_scolaire_id'=> $request->annee_scolaire_id ?? null,
                'ecole_precedente'=> $request->ecole_precedente ?? null,
                'sortie_ecole_precedente'=> $request->sortie_ecole_precedente ?? null,
                'raison_admission'=> $request->raison_admission ?? null,
                'status'=> $request->status ?? null,
            ]);

           } catch (\Exception){
                return response()->json([
                    'message' => "erreur interne"
                ], 500);
           }
           

        return response()->json([
            'message' => "Inscription de l'étudiant réussi",
        ]);
        }
    }
    public function update(){

    }
    public function delete() {

    }
}
