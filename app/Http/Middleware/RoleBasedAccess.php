<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's role
            $userRole = Auth::user()->role->name;

            // Check if the user has the required permission
            if (in_array($userRole, $roles)) {
                return $next($request);
            }
        }

        // If the user does not have the required permission, return an error response
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
