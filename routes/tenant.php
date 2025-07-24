<?php

declare(strict_types=1);

use App\Http\Controllers\AnneeScolaireController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EnseignementController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NiveauController;
use App\Models\Enseignement;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'api',
    'tenant.auth',
])->group(function () {

    Route::get('etablissement' , [EtablissementController::class, 'get']);

    Route::middleware('role:admin')->group(function(){

        Route::put( 'etablissement', [EtablissementController::class, 'update']);
        
        Route::post('etudiant', [EtudiantController::class, 'create']);

        Route::post('annee-scolaire', [AnneeScolaireController::class, 'createAnneeScolaire']);
        Route::post('periode', [AnneeScolaireController::class, 'createPeriode']);

        Route::post('matiere', [MatiereController::class, 'create']);
        Route::post('niveau', [NiveauController::class, 'create']);
        Route::post('classe', [ClasseController::class, 'create']);
        Route::post('enseignement', [EnseignementController::class, 'create']);
        Route::post('inscription', [EtudiantController::class, 'create']);

        Route::get('matiere', [MatiereController::class, 'get']);
        Route::get('classe', [ClasseController::class, 'get']);
        Route::get('enseignant', [AuthController::class, 'getEnseignant']);
        Route::get('enseignement', [EnseignementController::class, 'get']);
    });
});
