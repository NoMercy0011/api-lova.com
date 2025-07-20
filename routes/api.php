<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageUpdatedController;
use App\Http\Middleware\InitializeTenancyByHeader;
use App\Http\Middleware\VerifyDataBaseAccess;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

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
    Route::get('user', [AuthController::class, 'user']);
    Route::put( 'user-update', [AuthController::class, 'update']);
});

Route::get('hello', function(){
    return response()->json([
        'message' => 'Hello AlwaysData !!',
        'database' => DB::connection()->getDatabaseName(),
   ]);
})->middleware(InitializeTenancyByHeader::class);
