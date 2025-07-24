<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EtablissementController extends Controller
{
    public function get(){

        $etablissement = Etablissement::first();

        if(!$etablissement) {
            return response()->json([
                'status' => 404,
                'etablissement'=> 'Donnée vide...'
            ], 404);
        }
        
        return response()->json([
            'status' => 200,
            'etablissement' => $etablissement,
        ],200);
    }

    public function update(Request $request) {

        $user = $request->user();
        $etablissement = Etablissement::first();
        
        if(! $etablissement) {
            return response()->json([
                'status' => 404,
                'message'=> 'Donnée vide...'
            ], 404);
        }
        
        $validator = Validator::make($request->all(), [
            /*'etablissement'=> 'required|string',
            'dren' => 'required|string',
            'cisco'=> 'required|string',
            'contact'=> 'required|string',
            'code'=> 'required|string',
            'email'=> 'required|string',*/
        ]);
        
        if($validator->fails()){
            $error = $validator->errors();
            return response()->json([
                'message' => "Un erreur s'est produit",
                'errors' => $error,
                'status' => 401,
            ],401);
        }
        
        $data = $etablissement->update([
            'etablissement'=> $request->etablissement ?? null,
            'ville'=> $request->ville ?? null,
            'region'=> $request->region ?? null,
            'contact'=> $request->contact ?? null,
            'code'=> $request->code ?? null,
            'email'=> $request->email ?? null,
            'editeur' => $user->id_user ?? null,
        ]);
                
        return response()->json([
            'status' => 200,
            'message' => 'La base de donnée à été mis à jour',
            'etablissement' => $etablissement,
            'editeur' => $user->id_user ?? null,
        ],200);
    }
}
