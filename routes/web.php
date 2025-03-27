<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

// Controladores
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\Server\EggsController;
use App\Http\Controllers\Server\NodesController;
use App\Http\Controllers\Server\ServerListController;
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
});

// Privacidad
Route::get('/privacidad', function () {
    return view('privacidad');
})->middleware('auth')->name('privacidad.form');

Route::post('/privacidad/aceptar', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $user->privacidad_aceptada = true;
    $user->save();
    return redirect('/')->with('success', 'Gracias por aceptar la política de privacidad.');
})->middleware('auth')->name('privacidad.aceptar');

// Modo oscuro
Route::post('/darkMode', function (Request $request) {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $user->dark_mode = $request->input('dark');
    $user->save();
    return response()->json(['success' => true]);
})->middleware('auth');

// Perfil
Route::get('/perfil', function () {
    return 'Bienvenida a tu perfil privado, Nia!';
})->middleware(['auth', \App\Http\Middleware\VerificarPrivacidad::class]);

// Área protegida
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/logs', [LogsController::class, 'index'])->name('logs');

    Route::get('/server/eggs', [EggsController::class, 'index'])->name('server.eggs');
    Route::get('/server/nodes', [NodesController::class, 'index'])->name('server.nodes');
    Route::get('/server/servers', [ServerListController::class, 'index'])->name('server.servers');

    Route::get('/users/roles', [RolesController::class, 'index'])->name('users.roles');
    Route::get('/users', [UserController::class, 'index'])->name('users');

    Route::get('/advanced/health', [HealthController::class, 'index'])->name('advanced.health');
    Route::get('/advanced/api', [APIKeysController::class, 'index'])->name('advanced.api');
    Route::get('/advanced/db', [DBHostsController::class, 'index'])->name('advanced.db');
    Route::get('/advanced/mounts', [MountsController::class, 'index'])->name('advanced.mounts');
    Route::get('/advanced/webhooks', [WebhooksController::class, 'index'])->name('advanced.webhooks');
});
