<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserEstatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->estatus >= 1 || Auth::user()->role == 100){
            return $next($request);
        }else{
            verSweetAlert2('Usuario Inactivo', 'toast', 'error');
            return redirect()->route('cerrar');
        }
    }
}
