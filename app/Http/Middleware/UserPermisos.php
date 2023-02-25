<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class UserPermisos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (comprobarPermisos(Route::currentRouteName())){
            return $next($request);
        }else{
            verSweetAlert2('No tienes permisos suficientes', 'toast', 'error');
            return redirect()->route('dashboard');
        }
    }
}
