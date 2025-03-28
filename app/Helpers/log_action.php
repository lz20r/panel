<?php

use App\Helpers\Logger;

if (!function_exists('log_action')) {
    /**
     * Registra un log de acción del usuario.
     *
     * @param string $message Mensaje descriptivo
     * @param string $type Tipo de log (info, error, update, login, etc.)
     * @param array $metadata Información adicional (opcional)
     */
    function log_action(string $message, string $type = 'info', array $metadata = []): void
    {
        // Puedes agregar metadatos automáticos si querés:
        $metadata = array_merge($metadata, [
            'ip' => request()->ip(),
            'url' => request()->fullUrl(),
            'agent' => request()->userAgent(),
        ]);

        Logger::log($message, $type, $metadata);
    }
}
