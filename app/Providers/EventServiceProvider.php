<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use App\Listeners\LogUserActivity;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Lockout;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [LogUserActivity::class],
        Login::class => [LogUserActivity::class],
        Logout::class => [LogUserActivity::class],
        PasswordReset::class => [LogUserActivity::class],
        Lockout::class => [LogUserActivity::class],
    ];

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

    public function boot(): void
    {
        //
    }
}
