<?php

use App\Http\Middleware\LogAccess;
use App\Http\Middleware\LogLogout;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;

// Controladores
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\Server\EggsController;
use App\Http\Controllers\Server\NodesController;
use App\Http\Controllers\Server\ServerListController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\User\RolesController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Advanced\HealthController;
use App\Http\Controllers\Advanced\APIKeysController;
use App\Http\Controllers\Advanced\DBHostsController;
use App\Http\Controllers\Advanced\MountsController;
use App\Http\Controllers\Advanced\WebhooksController; 

// Página principal
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('cinammon.es')
    ->middleware(LogAccess::class);

// Página de inicio de sesión
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login')
    ->middleware(LogAccess::class);

// Ruta de cierre de sesión
Route::post('/logout', [LogoutController::class, 'logout'])
    ->name('logout')
    ->middleware(LogLogout::class);

// Página de registro
Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register')
    ->middleware(LogAccess::class);

// Página de recuperación de contraseña
Route::get('/forgot-password', function () {
    return Inertia::render('Auth/ForgotPassword');
})->name('password.request')
    ->middleware(LogAccess::class);

// Página de restablecimiento de contraseña
Route::get('/reset-password/{token}', function (Request $request, $token) {
    return Inertia::render('Auth/ResetPassword', [
        'email' => $request->input('email'),
        'token' => $token,
    ]);
})->name('password.reset')
    ->middleware(LogAccess::class);

// Página de verificación de correo electrónico
Route::get('/verify-email/{id}/{hash}', function (Request $request) {
    return Inertia::render('Auth/VerifyEmail', [
        'email' => $request->input('email'),
        'id' => $request->route('id'),
        'hash' => $request->route('hash'),
    ]);
})->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify')
    ->middleware(LogAccess::class);


// Pagina de aceptación de términos
Route::get('/terms', function () {
    return Inertia::render('Auth/AcceptTerms');
})->name('terms')
    ->middleware(LogAccess::class);

Route::get('/privacy', function () {
    return Inertia::render('Auth/AcceptTerms');
})->name('privacy')
    ->middleware(LogAccess::class);

// Notificación
Route::get('/notification', function () {
    return Inertia::render('Notification');
})->name('notification')
    ->middleware(LogAccess::class);
// Modo oscuro
Route::post('/darkMode', function (Request $request) {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $user->dark_mode = $request->input('dark');
    $user->save();

    // Asegúrate que sea booleano
    $dark = $request->boolean('dark');

    $user->update(['dark_mode' => $dark]);
    session(['dark_mode' => $dark]);

    return response()->json(['success' => true, 'dark' => $dark]);
})->middleware('auth')->name('darkmode.update')
    ->middleware(LogAccess::class);

Route::post('/darkmode-toggle', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $dark = !session('dark_mode', false);
    session(['dark_mode' => $dark]);

    // Si quieres guardarlo también en la base de datos:
    $user->update(['dark_mode' => $dark]);

    return back();
})->name('darkmode.toggle')->middleware('auth');

// Área protegida
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Eliminar logs antiguos (solo si hay más de 100)
    Route::delete('/dashboard/logs/clear-old', [LogsController::class, 'clearOld'])->name('logs.clear')
        ->middleware(LogAccess::class);
    Route::middleware(['auth'])->group(function () {
        Route::get('/terms', function () {
            return Inertia::render('TermsOfService');
        })->name('terms.show');

        // Rutas que registrarán los logs al ser accedidas
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard')
            ->middleware(LogAccess::class);
        Route::get('/dashboard/settings', [SettingsController::class, 'index'])
            ->name('settings')
            ->middleware(LogAccess::class);
        Route::get('/dashboard/logs', [LogsController::class, 'index'])->name('logs');
        Route::get('/dashboard/server/eggs', [EggsController::class, 'index'])
            ->name('server.eggs')
            ->middleware(LogAccess::class);
        Route::get('/server/nodes', [NodesController::class, 'index'])
            ->name('server.nodes')
            ->middleware(LogAccess::class);
        Route::get('/dashboard/server/servers', [ServerListController::class, 'index'])
            ->name('server.servers')
            ->middleware(LogAccess::class);
        Route::get('/dashboard/users/roles', [RolesController::class, 'index'])
            ->name('users.roles')
            ->middleware(LogAccess::class);
        Route::get('/dashboard/users', [UserController::class, 'index'])
            ->name('users')
            ->middleware(LogAccess::class);

        Route::get('/dashboard/advanced/health', [HealthController::class, 'index'])
            ->name('advanced.health')
            ->middleware(LogAccess::class);
        Route::get('/dashboard/advanced/api', [APIKeysController::class, 'index'])
            ->name('advanced.api')
            ->middleware(LogAccess::class);
        Route::get('/dashboard/advanced/db', [DBHostsController::class, 'index'])
            ->name('advanced.db')
            ->middleware(LogAccess::class);
        Route::get('/dashboard/advanced/mounts', [MountsController::class, 'index'])
            ->name('advanced.mounts')
            ->middleware(LogAccess::class);
        Route::get('/dashboard/advanced/webhooks', [WebhooksController::class, 'index'])
            ->name('advanced.webhooks')
            ->middleware(LogAccess::class);
    });
});
