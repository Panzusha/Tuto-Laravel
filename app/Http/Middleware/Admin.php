<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // si le user est authentifié et qu'il est admin
        // (ignorer l'erreur, isAdmin est définie dans Models/User.php)
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
