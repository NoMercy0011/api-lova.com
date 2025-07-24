<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatiereController extends Controller
{
    public function get(){
        $matiere = Matiere::all()->map(
            function($item) {
                return [
                    'id_matiere' => $item->id_matiere ?? null,
                    'matiere' => $item->matiere ?? null,
                    'code' => $item->code ?? null,
                ];
            }
        );
        return response()->json([
            'matieres' =>  $matiere,
        ]);
    }
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'matiere'=> 'required|string',
            'code' => 'required|string|unique:tenant.matiere',
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

            $dataCreated = Matiere::create([
                'matiere'=> $request->matiere ?? null,
                'code'=> $request->code ?? null,

            ]);

        return response()->json([
            'message' => "Création réussi",
            'data' => $dataCreated
        ]);
        }
    }
}
