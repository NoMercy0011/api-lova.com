<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function get(){
        $sections = Section::all();

        return response()->json([
            'sections' => $sections,
        ], 200);
    }
}
