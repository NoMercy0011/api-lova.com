<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if(!$user){
            return response()->json([
                'erreur' => 'Vous êtes non authentifier'
            ], 401);
        }

        if(!in_array($user->role ?? null, $roles)){
            return response()->json([
                'erreur' => 'Accès non autorisé'
            ], 403);
        }
        return $next($request);
    }
}
