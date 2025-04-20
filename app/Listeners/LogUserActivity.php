<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Lockout;
use App\Helpers\Logger;

class LogUserActivity
{
    public function handle($event): void
    {
        if ($event instanceof Registered) {
            Logger::logUserEvent($event, 'register', '🟢 Nuevo usuario registrado: ' . self::userInfo($event));
        }

        if ($event instanceof Login) {
            Logger::logUserEvent($event, 'login', '🔵 Usuario inició sesión: ' . self::userInfo($event));
        }

        if ($event instanceof Logout) {
            Logger::logUserEvent($event, 'logout', '🔴 Usuario cerró sesión: ' . self::userInfo($event));
        }

        if ($event instanceof PasswordReset) {
            Logger::logUserEvent($event, 'password_reset', '🟡 Usuario restableció contraseña: ' . self::userInfo($event));
        }

        if ($event instanceof Lockout) {
            Logger::logUserEvent(
                $event,
                'lockout',
                '🟠 Usuario bloqueado por intentos fallidos desde IP: ' . request()->ip() .
                    ' | Email intentado: ' . request()->input('email', 'desconocido')
            );
        }
    }

    private static function userInfo($event): string
    {
        $name = $event->user->name ?? 'Desconocido';
        $email = $event->user->email ?? 'sin-email';
        return "$name ($email)";
    }
}
