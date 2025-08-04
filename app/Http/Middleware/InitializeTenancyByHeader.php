<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenancyByHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenantID = $request->header('client-id');

        if(!$tenantID){
            return response()->json([
                'status' => 403,
                'message' => ' Client non spécifié, ID-client manquant',
            ], 403);
        }
        $tenant = Tenant::where('etablissement' ,$tenantID)->first();

        if(!$tenant){
            //abort(404, 'Client non trouvé');
            return response()->json([
                'status' => 404,
                'message' => "Etablissement Introuvalble ou incorrecte",
            ], 404);
        }

        tenancy()->initialize($tenant);

        $tenantId = tenant('id');


        Config::set( "database.connections.tenant",[
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'mysql-api-lova.alwaysdata.net'),
            'port' => env('DB_PORT', '3306'),
            'database' => $tenant->database ?? null,
            'username' => env($tenant->dot_env ?? null, 'api-lova'),
            'password' => $tenant->password ?? null | env('DB_CLIENT_PASSWORD'),
        ]);

        DB::purge('tenant');
        DB::connection('tenant');
        return $next($request);
    }
}
