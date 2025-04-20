<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\Logger;

class LogAccess
{
    public function handle(Request $request, Closure $next)
    {
        Logger::log(
            $request->route()?->getName() ?? 'ruta desconocida',
            'access', 
            [
                'user_id' => $request->user()?->id,
                'timestamp' => now(),
            ]
        );

        return $next($request);
    }
}
