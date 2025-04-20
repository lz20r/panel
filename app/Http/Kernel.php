<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Middleware\LogLogout; 
use App\Http\Middleware\LogAccess; 
class Kernel extends HttpKernel
{
    // No se necesita agregar middleware aquí
    protected $middleware = [];

    // Middleware de grupo
    protected $middlewareGroups = [
        'web' => [
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            SubstituteBindings::class, 
        ],

        'api' => [
            EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            SubstituteBindings::class,
            // No agregues el middleware aquí
        ],
    ];

    // Registrar middlewares por su alias
    protected $routeMiddleware = [
        'log.access' => LogAccess::class,
        'log.logout' => LogLogout::class,
    ];
}
