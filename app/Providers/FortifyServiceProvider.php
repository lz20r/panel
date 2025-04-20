<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use App\Http\Responses\CustomLogoutResponse;
use Laravel\Fortify\Contracts\LogoutResponse; 
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession; 

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LogoutResponse::class, CustomLogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // 🎯 Personalizamos el pipeline de autenticación
        Fortify::authenticateThrough(function ($request) {
            return [
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,

                // ✅ Registrar inicio de sesión y guardar datos para el logout
                function ($request, $next) {
                    if (Auth::check()) {
                        $user = Auth::user();

                        // 🧠 Guardamos los datos en la sesión para usarlos en el logout
                        $request->session()->put('user_id_backup', $user->id);
                        $request->session()->put('user_name_backup', $user->name);
                        $request->session()->put('user_email_backup', $user->email);

                        // 📝 Registramos el login con el logger
                        \App\Helpers\Logger::log(
                            '🔵 Usuario inició sesión: ' . $user->name . ' (' . $user->email . ')',
                            'login',
                            [
                                'user_id' => $user->id,
                                'timestamp' => now(),
                            ]
                        );
                    } else {
                        // ⛔ Si no está autenticado, lo redirigimos al login
                        return redirect()->route('login');
                    }

                    return $next($request);
                },
            ];
        });

        // ⏱️ Limitar intentos de login
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        // ⏱️ Limitar intentos 2FA
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
