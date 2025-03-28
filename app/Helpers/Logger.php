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
     * @param array $metadata Información adicional
     */
    public static function log($message, $type = 'info', $metadata = [])
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) return;

        $metadata['user_id'] = Auth::id();
        $metadata['ip_address'] = request()->ip();
        $metadata['url'] = request()->fullUrl();
        $metadata['user_agent'] = request()->userAgent();
        $metadata['method'] = request()->method();
        $metadata['route'] = request()->route()->getName();
        $metadata['input'] = request()->all();
        $metadata['exception'] = null;
        $metadata['created_at'] = now();
        $metadata['updated_at'] = now();

        // Asegúrate de agregar el tipo y el mensaje del log
        $logData = [
            'user_id' => $metadata['user_id'],
            'type' => $type,
            'message' => $message,
            'metadata' => json_encode($metadata),  // Convertir metadata en JSON
        ];

        // Intentar registrar el log en la base de datos
        try {
            LogEntry::create($logData);
            Log::info('✅ Log guardado correctamente');
        } catch (\Exception $e) {
            Log::error('❌ Error al guardar el log: ' . $e->getMessage());
        }
    }
}
