<?php

namespace App\Http\Controllers;

use App\Models\EnseignantActive;
use App\Models\EnseignantQuitte;

class EnseignantController extends Controller
{
    public function getEnseignant() {
        $enseignants = EnseignantActive::with([
            'enseignant',
            'section'
        ])->get()
        ->map( function($item) {
            return[
                //'data' => $item,
                'id_enseignant' => $item->id_enseignant_active,
                'pseudo' => $item->enseignant->pseudo,
                'nom' => $item->enseignant->nom,
                'prenom' => $item->enseignant->prenom,
                'email' => $item->enseignant->email,
                'sexe' => $item->enseignant->sexe,
                'section' => $item->section->section,
                'role' => $item->enseignant->role,
                'date_naissance' => $item->enseignant->date_naissance,
                'lieu_naissance' => $item->enseignant->lieu_naissance,
                'telephone' => $item->enseignant->telephone,
                'photo' => $item->enseignant->photo,
                'salaire' => $item->salaire,
                'status' => $item->status,
                'date_entree' => $item->enseignant->date_entree,
            ];
        });

        return response()->json([
            'total' => Count($enseignants),
            'enseignants' => $enseignants,
        ], 200);
    }

    public function getEnseignantQuitte(){
        $enseignants = EnseignantQuitte::with([
            'enseignant'
        ])->get()
        ->map( function($item) {
            return[
                //'data' => $item,
                'id_enseignant' => $item->id_enseignant_active,
                'pseudo' => $item->enseignant->pseudo,
                'nom' => $item->enseignant->nom,
                'prenom' => $item->enseignant->prenom,
                'sexe' => $item->enseignant->sexe,
                'role' => $item->enseignant->role,
            ];
        });

        return response()->json([
                'total' => Count($enseignants),
                'enseignants' => $enseignants,
        ], 200);
    }
}
