<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\Logger;

class LogAccess
{
    // Dentro de LogAccess.php
public function handle(Request $request, Closure $next){
    // vaciar los logs anteriores
    // crea un nuevo log de acceso dinámicamente
    Logger::log(
        $request->route()->getName(),
        'info', 
        [
            'user_id' => $request->user() ? $request->user()->id : null,
            'url' => $request->fullUrl(),
            'input' => $request->all(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'route' => $request->route()->getName(),
            'context' => [
                'method' => $request->method(),
                'route' => $request->route()->getName(),
                'input' => $request->all(),
                'ip' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'timestamp' => now(),
            ],
        ]
    );
    
    return $next($request);
}

}
