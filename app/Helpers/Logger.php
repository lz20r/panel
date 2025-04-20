<?php

namespace App\Helpers;

use App\Models\LogEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Logger
{
    public static function log($message, $type = 'info', $context = [])
    { 
        $count = LogEntry::count();
        if ($count > 100) {
            LogEntry::orderBy('created_at')->limit($count - 100)->delete();
        }

        try { 
            $type = trim(strtolower($type));

            $user = Auth::user();

            $logData = [
                'user_id'    => $user?->id,
                'type'       => $type,
                'message'    => $message,
                'url'        => request()->fullUrl(),
                'user_agent' => request()->userAgent(),
                'method'     => request()->method(),
                'route'      => request()->route()?->getName(),
                'input'      => request()->except(['password', 'token']),
                'exception'  => null,
                'ip'         => request()->ip(),
                'context'    => is_array($context) ? json_encode($context) : (string) $context,
            ];

            LogEntry::create($logData);

            self::logToConsole($type, $message, $logData);
            Log::debug("[$type] $message", $logData);
        } catch (\Exception $e) {
            $errorMessage = '❌ Error al guardar el log: ' . $e->getMessage();
            try {
                LogEntry::create([
                    'user_id'    => Auth::id(),
                    'type'       => 'error',
                    'message'    => 'Fallo en el logger',
                    'url'        => request()->fullUrl(),
                    'user_agent' => request()->userAgent(),
                    'method'     => request()->method(),
                    'route'      => request()->route()?->getName(),
                    'input'      => [],
                    'exception'  => $e->getMessage(),
                    'ip'         => request()->ip(),
                    'context'    => 'logger_internal_error',
                ]);
            } catch (\Exception $innerError) {
                Log::error('❌ Error crítico al guardar el fallo del logger: ' . $innerError->getMessage());
            }

            Log::error($errorMessage);
        }
    }

    public static function logUserEvent($event, $type, $message)
    {
        $user = $event->user ?? null;

        if ($user) {
            self::log($message, $type, [
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'route' => request()->route()?->getName(),
            ]);
        } else {
            Log::error('❌ No se pudo guardar el log: Usuario no autenticado');
        }
    }

    private static function logToConsole($type, $message, $data)
    {
        if (!app()->runningInConsole()) return;

        $colorMap = [
            'info'     => "\033[0;36m", // Cyan
            'error'    => "\033[0;31m", // Red
            'warning'  => "\033[1;33m", // Yellow
            'security' => "\033[0;35m", // Purple
            'form'     => "\033[0;32m", // Green
            'api'      => "\033[0;34m", // Blue
        ];

        $reset = "\033[0m";
        $color = $colorMap[$type] ?? "\033[0m";

        echo "{$color}[$type] $message | IP: {$data['ip']} | RUTA: {$data['route']}{$reset}" . PHP_EOL;
    }
}
