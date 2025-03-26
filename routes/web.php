<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Mostrar la política de privacidad
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

Route::post('/darkMode', function (Request $request) {

    /** @var \App\Models\User $user */
    $user = Auth::user();
    $user->dark_mode = $request->input('dark');
    $user->save();
    return response()->json(['success' => true]);
})->middleware('auth');

Route::get('/perfil', function () {
    return 'Bienvenida a tu perfil privado, Nia!';
})->middleware(['auth', \App\Http\Middleware\VerificarPrivacidad::class]);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
