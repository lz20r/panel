<?php

namespace App\Helpers;

use App\Models\LogEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Logger
{
    /**
     * Registra un log en la base de datos.
     *
     * @param string $message El mensaje del log
     * @param string $type Tipo de log (info, error, login, etc.)
     * @param array $context Información adicional opcional (guardado como JSON)
     */
    public static function log($message, $type = 'info', $context = [])
    {
        // Verifica si el usuario está autenticado
        //if (!Auth::check()) return;

        try {
            LogEntry::create([
                'user_id'    => Auth::id(),
                'type'       => $type,
                'message'    => $message,
                'url'        => request()->fullUrl(),
                'user_agent' => request()->userAgent(),
                'method'     => request()->method(),
                'route'      => request()->route()?->getName(),
                'input'      => request()->all(),
                'exception'  => null,
                'ip'         => request()->ip(),
                'context'    => $context, // array o null
            ]);

            Log::info("✅ Log guardado: {$type} - {$message}");
        } catch (\Exception $e) {
            Log::error('❌ Error al guardar el log: ' . $e->getMessage());
        }
    }
}
