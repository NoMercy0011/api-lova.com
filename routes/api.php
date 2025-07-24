<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'authenticate']);


Route::middleware('tenant.auth' )->group(function (){
    Route::get('profil', [AuthController::class, 'user']);
    Route::put( 'user-update', [AuthController::class, 'update']);
});

Route::get('hello', function(){
    return response()->json([
        'message' => 'Hello AlwaysData !!',
        'database' => DB::connection()->getDatabaseName(),
   ]);
});
