<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use App\Helpers\Logger;

class LogAuthEvents
{
    public function handle($event): void
    {
        if ($event instanceof Login) {
            Logger::log('Usuario inició sesión', 'login');
        }

        if ($event instanceof Logout) {
            Logger::log('Usuario cerró sesión', 'logout');
        }

        if ($event instanceof Registered) {
            Logger::log('Usuario se registró', 'register');
        }
    }
}
