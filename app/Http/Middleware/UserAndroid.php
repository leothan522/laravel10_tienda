<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $dispositivo = \hisorange\BrowserDetect\Facade::isAndroid();
        if (Auth::check()) {
            $role = Auth::user()->role;
        } else {
            $role = null;
        }
        if ($dispositivo || $role == 100) {
            return $next($request);
        } else {
            return redirect()->route('web.index');
        }
    }
}
