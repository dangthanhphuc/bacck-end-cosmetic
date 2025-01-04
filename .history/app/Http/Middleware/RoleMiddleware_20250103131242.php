<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles ): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if(!$user || !in_array($user->role, $roles)){
                return response()->json(['error' => 'Unauthorized. Required role not found.'], 403);
            }

            return $next($request);
        }catch (Exception $ex) {
            return response()->json(['error' => 'Unauthorized. Required role not found.'], 403);
        }
    }
}
