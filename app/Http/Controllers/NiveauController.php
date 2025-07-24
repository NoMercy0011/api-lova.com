<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NiveauController extends Controller
{
    public function get(){

    }
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'niveau'=> 'required|string|unique:tenant.niveau',
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

            $dataCreated = Niveau::create([
                'niveau'=> $request->niveau ?? null,

            ]);

        return response()->json([
            'message' => "Création réussi",
            'data' => $dataCreated
        ]);
        }
    }
    public function put(){
        
    }
    public function delete(){

    }
}
