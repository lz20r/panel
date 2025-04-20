<?php

namespace App\Http\Middleware;

use App\Helpers\Logger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogLogout
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado
        if ($request->user()) {
            // Registra el evento de logout en la base de datos
            Logger::log(
                '🔴 Usuario cerró sesión: ' . $request->user()->name . ' (' . $request->user()->email . ')',
                'logout',
                [
                    'user_id' => $request->user()->id,
                    'timestamp' => now(),
                ]
            );
        } else {
            Log::info('🚨 Usuario no autenticado al hacer logout');
        }

        // Llama al siguiente middleware
        return $next($request);
    }
}

