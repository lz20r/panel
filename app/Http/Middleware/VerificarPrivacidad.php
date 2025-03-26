<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarPrivacidad
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si la ruta actual ES la de privacidad, dejarla pasar
        if ($request->routeIs('privacidad.form')) {
            return $next($request);
        }

        if (Auth::check() && !Auth::user()->privacidad_aceptada) {
            return redirect()->route('privacidad.form')
                ->with('error', 'Debes aceptar la política de privacidad.');
        }

        return $next($request);
    }
}
