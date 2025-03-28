<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\LogEntry;

class LogsController extends Controller
{
    public function index()
    {
        // Obtener el tipo de log que se pasa desde el frontend (sin usar Request)
        $type = request()->query('type', '');  // Obtener 'type' directamente desde la URL

        // Obtener los logs con paginación y aplicar filtro si se pasa un tipo
        $logs = LogEntry::when($type, function ($query) use ($type) {
            return $query->where('type', $type);
        })->latest()->paginate(10);

        // Filtros disponibles
        $filters = [
            'alert',
            'advertencia',
            'critical',
            'login',
            'logout',
            'delete',
            'update',
            'create',
            'warning',
            'error',
            'success',
            'info',
            'notice',
            'debug',
            'trace',
            'emergency'
        ];

        // Pasamos $logs y $filters a la vista de la base de datos usando inertia
        return Inertia::render('Logs', [
            'logs' => $logs,
            'filters' => $filters,  // Esta es la variable que estaba causando el error
        ]);

    }
}
