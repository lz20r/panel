<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {

        // Cierra la sesión
        Auth::logout();

        // Borra la sesión de la aplicación
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirige a la página de inicio
        return redirect('/');
    }
}
