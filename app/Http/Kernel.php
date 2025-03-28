<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Middleware\LogRouteAccess;

class Kernel extends HttpKernel
{
    // No se necesita agregar middleware aquí
    protected $middleware = [
        'verificar.privacidad' => \App\Http\Middleware\VerificarPrivacidad::class,
        'log' => LogRouteAccess::class,
    ];

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
        // Otros middlewares...
        'log.route' => LogRouteAccess::class,  // Registra el middleware aquí
    ];
}
