<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\LogEntry;

class LogsController extends Controller
{
    public function index()
    {
        $type = strtolower(request()->query('type', ''));

        $logs = LogEntry::when(
            $type,
            fn($query) =>
            $query->whereRaw('LOWER(type) = ?', [$type])
        )->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends(['type' => $type]); 

        // Filtros traducidos
        $filters = [
            'access' => 'Acceso',
            'error' => 'Error',
            'warning' => 'Advertencia',
            'debug' => 'Depuración',
            'info' => 'Información',
            'sql' => 'SQL',
            'request' => 'Petición',
            'response' => 'Respuesta',
            'login' => 'Inicio de sesión',
            'logout' => 'Cierre de sesión',
            'register' => 'Registro',
            'lockout' => 'Bloqueo',
            'password_reset' => 'Restablecimiento de contraseña',
            'password_change' => 'Cambio de contraseña',
            'email_change' => 'Cambio de email',
            'two_factor' => 'Autenticación de dos factores',
            'two_factor_enabled' => 'Autenticación de dos factores habilitada',
            'two_factor_disabled' => 'Autenticación de dos factores deshabilitada',
        ];

        return Inertia::render('Logs', [
            'logs' => $logs,
            'filters' => $filters,
            'selectedFilter' => $type, // ✅ Enviamos cuál está activo
        ]);
    }

    public function clearOld()
    {
        $total = LogEntry::count();

        if ($total > 100) {
            $exceso = $total - 100;
            LogEntry::orderBy('created_at')->limit($exceso)->delete();

            return redirect()->route('logs')->with('success', "🧹 Se eliminaron $exceso logs antiguos.");
        }

        return redirect()->route('logs')->with('info', '✅ No hay suficientes logs para limpiar.');
    }
}
