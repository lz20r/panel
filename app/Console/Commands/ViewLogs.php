<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ViewLogs extends Command
{
    /**
     * El nombre y la firma del comando.
     *
     * @var string
     */
    protected $signature = 'logs:view';

    /**
     * La descripción del comando.
     *
     * @var string
     */
    protected $description = 'Muestra el contenido del archivo de logs de Laravel';

    /**
     * Ejecutar el comando.
     *
     * @return void
     */
    public function handle()
    {
        // Verificar si el archivo de logs existe
        $logFile = storage_path('logs/laravel.log');

        if (File::exists($logFile)) {
            // Leer el contenido del archivo de logs
            $logs = File::get($logFile);

            // Mostrar los logs en la consola
            $this->info($logs);
        } else {
            // Si no existe el archivo de logs, mostrar un mensaje
            $this->error('El archivo de logs no existe.');
        }
    }
}
