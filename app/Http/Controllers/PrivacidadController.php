<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivacidadController extends Controller
{
    public function mostrarFormulario()
    {
        return inertia('Privacidad'); // O return view() si no usas Inertia
    }

    public function aceptar()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->privacidad_aceptada = true;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Has aceptado la política de privacidad.');
    }
}
