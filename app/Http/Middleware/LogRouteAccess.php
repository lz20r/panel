<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\LogEntry;

class LogRouteAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Agrega un log para verificar si se ejecuta el middleware
        Log::info('Middleware ejecutado', ['route' => $request->route()->getName()]);

        // Solo registrar el log si el usuario está autenticado
        if (Auth::check()) {
            $routeName = $request->route()->getName();  // Obtiene el nombre de la ruta actual
            $user = Auth::user();  // Obtiene el usuario autenticado

            // Registrar un log en el sistema para verificar que el middleware se ejecuta
            Log::info('Acceso a la ruta', [
                'route' => $routeName,
                'user' => $user ? $user->id : 'Invitado',
                'ip_address' => $request->ip(),
            ]);

            // Guardar el log en la base de datos
            try {
                LogEntry::create([
                    'type' => 'info',
                    'message' => 'Accedió a la ruta: ' . $routeName,
                    'metadata' => json_encode([
                        'route' => $routeName,
                        'user_id' => $user ? $user->id : null,
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]),
                ]);
                Log::info('Log guardado en la base de datos');
            } catch (\Exception $e) {
                Log::error('Error al guardar el log: ' . $e->getMessage());
            }
        }

        // Continuar con la solicitud
        return $next($request);
    }
}
