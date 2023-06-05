<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpFoundation\Response;

class UserAndroid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $dispositivo = new Agent();
        if (Auth::check()) {
            $role = Auth::user()->role;
        } else {
            $role = null;
        }
        if ($dispositivo->isMobile() || $role == 100) {
            return $next($request);
        } else {
            return redirect()->route('web.index');
        }
    }
}
